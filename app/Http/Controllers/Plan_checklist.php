<?php

namespace App\Http\Controllers;

use App\Models\Checklist_item;
use App\Models\Checklist_result;
use App\Models\Checklist_result_detail;
use App\Models\Machine_list;
use App\Models\Machine_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Plan_checklist extends Controller
{

    public function __construct()
    {
        //return view('login');
    }
    // Controller created_plan_checklist

    public function index_plan()
    {
        $assets = ['calender'];
        return view('ilsung.pages.Plan-checklist', compact('assets'));
    }
    public function created_plan_checklist(Request $request)
    {
        $table_result = 'App\\Models\\Checklist_result';
        $date_form = $request->input('date');

        // Kiểm tra xem có dữ liệu ngày không
        if (!$date_form) {
            return response()->json(['status' => 400, 'message' => 'Ngày không hợp lệ.']);
        }

        if ($request->ajax()) {
            if (class_exists($table_result)) {
                FacadesDB::beginTransaction(); // Bắt đầu transaction
                try {
                    // Lấy danh sách checklist đã có cho ngày này
                    $existingChecklists = $table_result::where('Date_check', $date_form)
                        ->select('Code_machine', 'ID_item_checklist')
                        ->get()
                        ->groupBy('Code_machine')
                        ->map(function ($group) {
                            return $group->pluck('ID_item_checklist')->toArray();
                        })
                        ->toArray();

                    // Lấy danh sách mã máy từ bảng Machine_list
                    $data_check_list_1 = [];
                    $id_count = $table_result::max('id');

                    $data_list_machine = Machine_master::all();
                    foreach ($data_list_machine as $machine) {
                        $machine_list = Machine_list::where('Machine', $machine->Machine)->where('Status', 'Use')->get();
                        $item_checklist = Checklist_item::where('Machine', $machine->Machine)->get();

                        foreach ($machine_list as $item) {
                            foreach ($item_checklist as $item_check) {
                                // Kiểm tra xem checklist đã tồn tại chưa


                                if (
                                    !(isset($existingChecklists[$item->Code_machine]) &&
                                        in_array($item_check->id, $existingChecklists[$item->Code_machine])
                                    )
                                ) {
                                    $id_count++;
                                    $data_check_list_1[] = [
                                        'id' => $id_count,
                                        'ID_item_checklist' => $item_check->id,
                                        'ID_checklist' => $item_check->ID_checklist,
                                        'Locations' => $item->Locations,
                                        'Model' => "---",
                                        'Machine' => $item->Machine,
                                        'Code_machine' => $item->Code_machine,
                                        'item_checklist' => $item_check->item_checklist,
                                        'Khung_check' => $item_check->khung_check,
                                        'Shift' => $item_check->Shift,
                                        'PIC_check' => "EQM",
                                        'Status' => $item->Status,
                                        'Check_status' => 'Pending',
                                        'Remark' => '',
                                        'Date_check' => $date_form,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            }
                        }
                    }

                    // Chèn dữ liệu mới chỉ nếu có
                    if (!empty($data_check_list_1)) {
                        $table_result::insert($data_check_list_1);
                    }

                    FacadesDB::commit(); // Commit transaction
                    return response()->json([
                        'status' => 200,
                        'existing_count' => array_sum(array_map('count', $existingChecklists)), // Số lượng checklist đã tồn tại
                        'new_count' => count($data_check_list_1), // Số lượng checklist mới được thêm
                    ]);
                } catch (\Exception $e) {
                    FacadesDB::rollBack(); // Rollback transaction nếu có lỗi
                    return response()->json([
                        'status' => 500,
                        'message' => 'Lỗi: ' . $e->getMessage(),
                    ]);
                }
            }

            return response()->json(['status' => 400]);
        }

        return response()->json(['status' => 400]);
    }

    public function delete_plan_checklist(Request $request)
    {
        $date_form = $request->input('date');

        if ($request->ajax()) {
            Checklist_result::where('Date_check', $date_form)->delete();
            Checklist_result_detail::where('Date_check', $date_form)->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Bạn đã xoá Plan thành công'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Xoá không thành công'
            ]);
        }
        $notification = array(
            'message' => 'Successfully Done',
            'alert-type' => 'success'
        );

       
    }

    public function search_check_list_plan(Request $request)
    {

        $line = ($request->input('line') == '') ? null : $request->input('line');
        $shift = ($request->input('shift') == '') ? null : $request->input('shift');
        $Check_status = ($request->input('Status') == '') ? null : $request->input('Status');
        $date_form = $request->input('date_form');
        $table = 'App\\Models\\checklist_result';

        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at']);
                $data = Checklist_result::where('Shift', 'LIKE', '%' . $shift . '%')
                    ->where('Locations', 'LIKE', '%' . $line . '%')
                    ->where('Check_status', 'LIKE', '%' . $Check_status . '%')
                    ->where('Date_check', $date_form)
                    ->orderBy('Check_status', "desc")
                    ->get();

                return response()->json([
                    'data' => $data,
                    'colums' => $colums,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }


    public function show_plan()
    {
        $eventsData = DB::table('Checklist_result')
            ->select(DB::raw('Date_check, 
                                 COUNT(*) as total_count, 
                                 SUM(CASE WHEN Check_status = "Completed" THEN 1 ELSE 0 END) as completed_count, 
                                 SUM(CASE WHEN Check_status = "Pending" THEN 1 ELSE 0 END) as pending_count'))
            ->groupBy('Date_check')
            ->get();

        return response()->json($eventsData);
    }
}
