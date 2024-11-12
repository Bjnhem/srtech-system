<?php

namespace App\Http\Controllers;

use App\Models\check_list;
use Session;
use App\Models\Checklist_item;
use App\Models\Checklist_master;
use App\Models\Checklist_result;
use App\Models\Checklist_result_detail;
use App\Models\line;
use App\Models\Machine;
use App\Models\Machine_list;
use App\Models\Machine_master;
use App\Models\Model_master;
use App\Models\result_check_list;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;

class check_list_controller extends Controller
{
    public function __construct()
    {
        //return view('login');
    }

    public function index_checklist_show($line)
    {

        $line_id = line::where('Line_name', $line)->pluck('id')->first();
        $assets = [ 'animation'];
        return view('ilsung.pages.Check-checklist', compact('line_id', 'assets'));
    }



    public function check_list_masster(Request $request)
    {
        $machine = Machine_master::all();
        $line = line::all();
        $model = Model_master::all();
        // $machine_search = $machine->first();
        // $list_machine_id = Machine_list::where("Machine", $machine_search)->get();
        // $list_item_checklist = Checklist_master::where('Machine', $machine_search)->select('item_checklist')->distinct()->pluck('item_checklist');
        // $khung_check = Checklist_master::where("Machine", $machine_search)->where('item_checklist', $list_item_checklist->first())->get();
        return response()->json(
            [
                'machine' => $machine,
                'line' => $line,
                'model' => $model,
            ]
        );
    }


    public function Machine_ID_search(Request $request)
    {
        $Machine_id = $request->input("machine_id");
        $ID_Machine = Machine_list::where('ID_machine', $Machine_id)->get();
        $Machine = Machine_master::where('id', $Machine_id)->first();
        $list_item_checklist = Checklist_master::where('Machine', $Machine->Machine)->get();
        return response()->json(
            [
                'ID_machine' => $ID_Machine,
                'checklist_item' => $list_item_checklist,
            ]
        );
    }

    public function Khung_check(Request $request)
    {

        $item_check = $request->input("item_check");
        $khung_check = Checklist_item::where("ID_checklist", $item_check)->get();
        return response()->json(
            [
                'khung_check' => $khung_check,
            ]
        );
    }


    public function check_list_detail(Request $request)
    {

        // $machine = $request->input("machine");
        $item_check = $request->input("item_check");
        $check_list_detail = check_list::where('ID_checklist', $item_check)->get();
        return response()->json(
            [
                'data_checklist' => $check_list_detail,
            ]
        );
    }

    public function check_list_edit_detail(Request $request)
    {

        $id_check_list = $request->input("id_checklist");
        $check_list_detail = Checklist_result_detail::where('ID_checklist_result', $id_check_list)->get();
        return response()->json(
            [
                'data_checklist' => $check_list_detail,
            ]
        );
    }


    public function save_check_list(Request $request, $table)
    {
        // Lấy dữ liệu từ request
        $id_item_checklist = $request->input('id_checklist');
        $Model = $request->input('Model');
        $details = $request->input('details'); // Lấy thông tin chi tiết

        // Kiểm tra sự tồn tại của checklist
        $check = Checklist_result::where('id', $id_item_checklist)->first();

        if ($check) {

            // Cập nhật trạng thái và model
            $id_checklist_detail = $check->id;

            // Nếu có thông tin chi tiết, lưu vào bảng Checklist_result_detail
            if (!empty($details) && is_array($details)) {
                foreach ($details as $item) {
                    // Thêm ID_checklist_result vào từng item
                    $item['ID_checklist_result'] = $id_checklist_detail;
                    Checklist_result_detail::create(attributes: $item);
                }
            }
            $checklist_detail = Checklist_result_detail::where('ID_checklist_result', $id_checklist_detail)->first();
            if ($checklist_detail) {
                $check->Check_status = "Completed";
                $check->Model = $Model;
                $check->save(); // Lưu thay đổi
            }

            return response()->json([
                'id' => $id_checklist_detail,
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }
    }

    public function delete_check_list($id)
    {
        // Tìm checklist result
        $checklistResult = Checklist_result::find($id);

        if ($checklistResult) {
            // Xóa các chi tiết liên quan
            Checklist_result_detail::where('ID_checklist_result', $id)->delete();
            $checklistResult->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Xóa thành công.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu.'
            ]);
        }
    }



    public function update_check_list_detail(Request $request, $table)
    {
        $data = $request->all();
        Checklist_result_detail::where("id_checklist_result", $table)->delete();
        foreach ($data as $item) {
            Checklist_result_detail::create($item);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Register Successfully.'
        ]);
    }



    public function search_check_list_overview(Request $request)
    {

        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $Code_machine = ($request->input('Code_machine') == '') ? null : $request->input('Code_machine');
        $shift = ($request->input('shift') == 'All') ? null : $request->input('shift');
        $Check_status = ($request->input('Status') == 'All') ? null : $request->input('Status');
        $date_form = $request->input('date_form');
        $table = 'App\\Models\\checklist_result';

        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at']);
                $data = Checklist_result::where('Shift', 'LIKE', '%' . $shift . '%')
                    ->where('Locations', 'LIKE', '%' . $line . '%')
                    ->where('Code_machine', 'LIKE', '%' . $Code_machine . '%')
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

    // Controller created_plan_checklist
    public function created_plan_checklist(Request $request)
    {
        $table_result = 'App\\Models\\checklist_result';
        $date_form = $request->input('date');
        if ($request->ajax()) {
            if (class_exists($table_result)) {
                $data = $table_result::where('Date_check', $date_form)
                    ->pluck('Code_machine')->toArray();
                $data = array_unique($data);

                $data_check_list = Machine_list::whereNotIn('Code_machine', $data)->get();
                $data_check_list_1 = [];
                $id_count = $table_result::max('id');;
                $count = $id_count;
                foreach ($data_check_list as $item) {
                    $Item_checklist = Checklist_item::where('Machine', $item->Machine)->get();
                    foreach ($Item_checklist as $item_check) {
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
                            'created_at' => now(), // Thêm dòng này
                            'updated_at' => now(),
                        ];
                    }
                }

                $table_result::insert($data_check_list_1);
                return response()->json([
                    'status' => 200,
                    'count' => $id_count - $count,
                ]);
            }
            return response()->json([
                'status' => 400,
            ]);
        }
        return response()->json([
            'status' => 400,
        ]);
    }


    public function search_check_list_plan(Request $request)
    {

        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shift') == 'All') ? null : $request->input('shift');
        $Check_status = ($request->input('Status') == 'All') ? null : $request->input('Status');
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



    // Controller check_machine_ID

    public function Check_machine_ID(Request $request)
    {

        // Lấy ID máy từ request (mã QR)
        $machineId = $request->input('machine_id');
        // Kiểm tra mã máy trong cơ sở dữ liệu
        $machine = Checklist_result::where('Code_machine', $machineId)->first(); // Giả sử bạn có cột `machine_id` trong bảng `machines`

        // Nếu tìm thấy, trả về kết quả hợp lệ
        if ($machine) {
            return response()->json([
                'isValid' => true,
                'machine_id' => $machine->Code_machine, // Hoặc trường bạn muốn trả về
            ]);
        } else {
            // Nếu không tìm thấy mã máy, trả về kết quả không hợp lệ
            return response()->json([
                'isValid' => false,
                'message' => 'Mã QR không hợp lệ.',
            ]);  // Trả về mã lỗi 400 để chỉ ra lỗi
        }
    }



    public function search_check_list(Request $request)
    {

        $check_list = ($request->input('check_list') == '---') ? null : $request->input('check_list');
        $cong_doan = ($request->input('cong_doan') == '---') ? null : $request->input('cong_doan');
        $line_type = ($request->input('line_type') == '---') ? null : $request->input('line_type');
        $phan_loai = ($request->input('phan_loai') == '---') ? null : $request->input('phan_loai');
        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shift') == '---') ? null : $request->input('shift');
        $tinh_trang = ($request->input('tinh_trang') == '---') ? null : $request->input('tinh_trang');
        $status = ($request->input('status') == '---') ? null : $request->input('status');
        $date_to = Carbon::createFromFormat('Y-m-d', $request->input('date_to'))->endOfDay();
        $date_form = Carbon::createFromFormat('Y-m-d', $request->input('date_form'))->startOfDay();

        $table = 'App\\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at']);
                $data = $table::select($colums)
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' . $shift . '%')
                    ->where('status', 'LIKE', '%' . $status . '%')
                    ->where('tinh_trang', 'LIKE', '%' . $tinh_trang . '%')
                    ->whereBetween('date', [$date_form, $date_to])
                    ->orderBy('id', 'asc')->get();

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

    public function search_check_list_view(Request $request)
    {

        $id = $request->input('id');
        $table = 'App\\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at', 'created_at']);
                $data = $table::select($colums)
                    ->where('id_check_list', $id)
                    ->orderBy('id', 'asc')->get();

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


    public function save_edit_check_list(Request $request, $table)
    {
        $data = $request->all();
        foreach ($data as $item) {
            $check_list = result_check_list::create($item);
        }

        $id_check_list = $check_list->id;

        return response()->json([
            'id' => $id_check_list,
            'status' => 200,
            'message' => 'Register Successfully.'
        ]);
    }





    public function delete_row(Request $request)
    {
        $table_1 = 'App\Models\\' . $request->input('table1');
        $table_2 = 'App\Models\\' . $request->input('table2');
        $row_id_delete = $request->input('rowId');
        if ($request->ajax()) {
            if (class_exists($table_1)) {

                $table_1::whereIn('id', $row_id_delete)->delete();
                $table_2::whereIn('id_check_list', $row_id_delete)->delete();
                return response()->json([
                    'status' => 200,

                ]);
            }
            return abort(404);
        }
        return abort(404);
    }
    /*     public function update_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('id');
        // dd($table);
        $validator = Validator::make($request->all(), [
            'csv_file' => [
                'required',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
            ]);
        } else {

            if (Storage::exists("csv/data.csv")) {
                Storage::delete("csv/data.csv");
            };
            $path = $request->file('csv_file')->storeAs('csv', 'data.csv');
            $path_2 = str_replace('\\', '/', storage_path("app/public/" . $path));
            $csv = Reader::createFromPath($path_2, 'r');
            $csv->setHeaderOffset(0);

            foreach ($csv as $record) {
                // dd($record);
                $table::updateOrCreate(
                    ['id' => $record['id']],
                    $record
                );
            }
            Storage::delete($path_2);
            return redirect()->back()->with('success', 'update dữ liệu thành công');
        }
    }
 */
    public function edit_table(Request $request, $model)
    {

        $table = 'App\\Models\\' . $model;
        $models = new $table;
        $tables = $models->getTable();
        $colum = Schema::getColumnListing($tables);

        if ($request->input('action') == 'edit') {
            $data = $request->only($colum);
            $table::where('id', $request->input('id'))->update($data);
            return response()->json($request->all());
        }

        if ($request->input('action') == 'delete') {
            $table::where('id', $request->input('id'))->delete();
            return response()->json($request->all());
        }
    }




    public function changeLanguage($language)
    {
        if (!in_array($language, ['en', 'ko', 'vi'])) {
            abort(400);
        }

        /*   echo App::setLocale($language); */
        /*  Session::put('website_language', $language); */
        return redirect()->back();
    }
}
