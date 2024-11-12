<?php

namespace App\Http\Controllers;

use App\Models\check_list;
use App\Models\phan_loai;
use App\Models\check_list_detail;
use App\Models\Checklist_item;
use App\Models\cong_doan;
use App\Models\ftg_1_result;
use App\Models\ftg_1_result_detail;
use App\Models\ftg_master_line;
use App\Models\ftg_result;
use App\Models\ftg_result_detail;
use App\Models\line;
use App\Models\line_type;
use App\Models\Machine_list;
use App\Models\master_check_list_line;
use App\Models\nhan_vien_check_list;
use App\Models\pad_master_line;
use App\Models\result_check_list;
use App\Models\result_check_list_detail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use Illuminate\Http\Request;

class admin_check_list_controller extends Controller
{
    public function __construct()
    {
        //return view('login');
    }


    public function index()
    {
        $view = 'FTG';
        return view('Checklist_EQM.pages.check-list.checklist-index', compact('view'));
    }


    public function admin()
    {
        return view('pro_3m.admin.admin');
    }

    public function check_list_search(Request $request)
    {

        $group = $request->input("group");
        $list_group = check_list::where('Group', $group)->get();
        $list_gen = nhan_vien_check_list::where('groups', $group)->get();
        $list_part = nhan_vien_check_list::where('groups', $group)->distinct()->pluck('part');

        return response()->json(
            [
                'data' => $list_group,
                'gen_list' => $list_gen,
                'part_list' => $list_part,
            ]
        );
    }

    public function cong_doan_search(Request $request)
    {

        $check_list_id = $request->input("id");
        $list_cong_doan = cong_doan::where('id_line_type', $check_list_id)->get();

        return response()->json(
            [
                'data' => $list_cong_doan,
            ]
        );
    }

    public function line_type_search(Request $request)
    {

        $cong_doan_id = $request->input("id");
        $list = line_type::where('id_check_list', $cong_doan_id)->get();

        return response()->json(
            [
                'data' => $list,
            ]
        );
    }

    public function check_list_detail(Request $request)
    {

        $line_type_id = $request->input("id");
        $check_list_detail = check_list_detail::where('id_phan_loai', $line_type_id)->get();
        return response()->json(
            [
                'data_check_list' => $check_list_detail,
            ]
        );
    }


    public function check_list_detail_edit(Request $request)
    {

        $line_type_id = $request->input("id");
        if ($request->ajax()) {
            $data = check_list_detail::all();
            $colum = array_keys($data->first()->getAttributes());
            $colums = array_diff($colum, ['created_at',  'updated_at']);
            $data = check_list_detail::where('id_phan_loai', $line_type_id)->select($colums)->get();

            return response()->json([
                'data' => $data,
                'colums' => $colums,
                'status' => 200,
            ]);
        }
        return abort(404);
    }


    public function phan_loai_search(Request $request)
    {

        $line_type_id = $request->input("id");
        $line = 'App\\Models\\' . $request->input("groups") . '_line';
        $list1 =  $line::where('id_cong_doan', $line_type_id)->get();
        $list2 = phan_loai::where('id_cong_doan', $line_type_id)->get();
        return response()->json(
            [
                'data1' => $list1,
                'data2' => $list2,
            ]
        );
    }

    public function search_check_list(Request $request)
    {

        $check_list = ($request->input('check_list') == '---') ? null : $request->input('check_list');
        $cong_doan = ($request->input('cong_doan') == '---') ? null : $request->input('cong_doan');
        $line_type = ($request->input('line_type') == '---') ? null : $request->input('line_type');
        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shift') == '---') ? null : $request->input('shift');
        $tinh_trang = ($request->input('tinh_trang') == '---') ? null : $request->input('tinh_trang');
        $status = ($request->input('status') == '---') ? null : $request->input('status');
        $date_form = $request->input('date_form');
        $date_to = $request->input('date_to');

        $table = 'App\\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                /*  $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at']); */
                $data = $table::where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->where('status', 'LIKE', '%' .  $status . '%')
                    ->where('tinh_trang', 'LIKE', '%' . $tinh_trang . '%')
                    ->whereBetween('date', [$date_form, $date_to])
                    ->get();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
                /* return $data; */
            }
            return abort(404);
        }
        return abort(404);
    }

    public function search_check_list_overview(Request $request)
    {
        $check_list = ($request->input('check_list') == '---') ? null : $request->input('check_list');
        $cong_doan = ($request->input('cong_doan') == '---') ? null : $request->input('cong_doan');
        $line_type = ($request->input('line_type') == '---') ? null : $request->input('line_type');
        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shift') == '---') ? null : $request->input('shift');
        $groups = ($request->input('groups') == '---') ? null : $request->input('groups');
        $phan_loai = ($request->input('phan_loai') == '---') ? null : $request->input('phan_loai');
        /*         $date_form = Carbon::createFromFormat('Y-m-d', $request->input('date_form'))->startOfDay(); */
        $date_form = $request->input('date_form');
        $table = 'App\\Models\\' . $request->input('table');
        $master_line = 'App\\Models\\' . $request->input('groups') . '_master_line';
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['updated_at']);
                $data = $table::select($colums)
                    ->where('groups', 'LIKE', '%' . $groups . '%')
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->where('date', $date_form)
                    ->pluck('id_check_list_line')->toArray();
                /*   ->get(); */
                $data = array_unique($data);
                $data_check_list = $master_line::whereNotIn('id', $data)
                    ->where('groups', 'LIKE', '%' . $groups . '%')
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->get();

                return response()->json([
                    'data' => $data_check_list,
                    'colums' => $colums,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function check_list_detail_overview(Request $request)
    {

        $line_type_id = $request->input("id");
        $id = $request->input("id_master");
        $master_line = 'App\\Models\\' . $request->input('groups') . '_master_line';
        $data_master = $master_line::where('id', $id)->get();
        $check_list = 'App\\Models\\' . $request->input('groups') . '_check_list_detail';
        $check_list_detail = $check_list::where('id_phan_loai', $line_type_id)->get();
        return response()->json(
            [
                'data_check_list' => $check_list_detail,
                'data_master' => $data_master,
            ]
        );
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
                    ->where('id_check_list', $id)->get();

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


    public function save_check_list_pending(Request $request, $table)
    {
        $table_result = 'App\\Models\\' . $table;
        $id_check_list_line = $request->input('id_check_list_line');
        $date = $request->input('date');
        $data = $request->all();
        $data2 =  $table_result::where('id_check_list_line', $id_check_list_line)
            ->where('date', $date)->first();

        if ($data2) {
            return response()->json([
                'status' => 400,
            ]);
        } else {
            $check_list =  $table_result::create($data);
            $id_check_list = $check_list->id;
            return response()->json([
                'id' =>  $id_check_list,
                'status' => 200,
            ]);
        }
    }

    public function save_check_list(Request $request, $table)
    {
        $table_result = 'App\\Models\\' . $table;
        $group = $request->input('groups');
        $check_list = $request->input('check_list');
        $cong_doan = $request->input('cong_doan');
        $line_type = $request->input('line_type');
        $line = $request->input('line');
        $phan_loai = $request->input('phan_loai');
        $shift = $request->input('shifts');
        $date = $request->input('date');

        $check = $table_result::where('groups', $group)
            ->where('check_list', $check_list)
            ->where('cong_doan', $cong_doan)
            ->where('line_type', $line_type)
            ->where('phan_loai', $phan_loai)
            ->where('line', $line)
            ->where('shifts', $shift)
            ->where('date', $date)
            ->first();

        if ($check) {
            return response()->json([
                'status' => 400,
            ]);
        } else {
            $data = $request->all();
            $check_list_record = $table_result::create($data);
            $check2 = master_check_list_line::where('groups', $group)
                ->where('check_list', $check_list)
                ->where('line_type', $line_type)
                ->where('cong_doan', $cong_doan)
                ->where('phan_loai', $phan_loai)
                ->where('line', $line)
                ->where('shifts', $shift)
                ->first();

            if ($check2) {
                $check_list_record->id_check_list_line = $check2->id;
                $check_list_record->save();

                $id_check_list = $check_list_record->id;

                return response()->json([
                    'id' =>  $id_check_list,
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                ]);
            }
        }
    }

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
    public function save_check_list_historry(Request $request)
    {
        $table_result = 'App\\Models\\' .  $request->input('table');
        $table_result_detail = 'App\\Models\\' . $request->input('table_2');
        $master_line = 'App\\Models\\' . $request->input('groups') . '_master_line';
        $check_list_master = 'App\\Models\\' . $request->input('groups') . '_check_list_detail';

        $check_list = ($request->input('check_list') == '---') ? null : $request->input('check_list');
        $cong_doan = ($request->input('cong_doan') == '---') ? null : $request->input('cong_doan');
        $line_type = ($request->input('line_type') == '---') ? null : $request->input('line_type');
        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shifts') == '---') ? null : $request->input('shifts');
        $groups = ($request->input('groups') == '---') ? null : $request->input('groups');
        $phan_loai = ($request->input('phan_loai') == '---') ? null : $request->input('phan_loai');
        $date_form = $request->input('date');
        if ($request->ajax()) {
            if (class_exists($table_result)) {
                $data = $table_result::where('groups', 'LIKE', '%' . $groups . '%')
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->where('date', $date_form)
                    ->pluck('id_check_list_line')->toArray();

                $data = array_unique($data);

                $data_check_list = $master_line::whereNotIn('id', $data)->get();
                $data_check_list_1 = [];
                $data_check_list_2 = [];
                $id_count = $table_result::latest()->value('id');
                $nhan_vien_master = nhan_vien_check_list::all();

                foreach ($data_check_list as $item) {

                    if ($item->phan_loai == 'EQM') {
                        $nhan_vien = $nhan_vien_master->where('groups', $groups)
                            ->where('phan_loai', $item->phan_loai)
                            ->random();
                        dd($nhan_vien);

                        // $nhan_vien = nhan_vien_check_list::where('groups', $groups)
                        //     ->where('phan_loai', $item->phan_loai)
                        //     ->inRandomOrder()->first();
                    } else {
                        $nhan_vien = $nhan_vien_master->where('groups', $groups)
                            ->where('phan_loai', 'production')
                            ->where('line_type', $item->line_type)
                            ->random();
                        // $nhan_vien = nhan_vien_check_list::where('groups', $groups)
                        //     ->where('phan_loai', 'production')
                        //     ->where('line_type', $item->line_type)
                        //     ->inRandomOrder()->first();
                        dd($nhan_vien);
                    }
                    $id_count++;

                    $data_check_list_1[] = [
                        'id' => $id_count,
                        'id_check_list_line' => $item->id,
                        'groups' => $item->groups,
                        'check_list' => $item->check_list,
                        'cong_doan' => $item->cong_doan,
                        'line_type' => $item->line_type,
                        'phan_loai' => $item->phan_loai,
                        'line' => $item->line,
                        'shifts' => $item->shifts,
                        'name' => $nhan_vien->name . ' - ' . $nhan_vien->gen,
                        'part' => $nhan_vien->part,
                        'status' => 'OK',
                        'problem' => '',
                        'process' => '',
                        'tinh_trang' => 'ON',
                        'date' => $date_form,
                    ];

                    $id_phan_loai = $item->id_phan_loai;

                    /*   $check_list_detail =  $check_list_master::where('id_phan_loai', $id_phan_loai)->get();
                    foreach ($check_list_detail as $item_detail) {
                        $data_check_list_2[] = [
                            'id_check_list' => $id_count,
                            'groups' => $item->groups,
                            'check_list' => $item->check_list,
                            'cong_doan' => $item->cong_doan,
                            'line_type' => $item->line_type,
                            'phan_loai' => $item->phan_loai,
                            'comment' => $item_detail->comment,
                            'line' => $item->line,
                            'shifts' => $item->shifts,
                            'name' => $nhan_vien->name . ' - ' . $nhan_vien->gen,
                            'part' => $nhan_vien->name,
                            'status' => 'OK',
                            'problem' => '',
                            'process' => '',
                            'tinh_trang' => 'ON',
                            'date' => $date_form,
                        ];
                    } */
                }

                $table_result::insert($data_check_list_1);
                /*     $table_result_detail::insert($data_check_list_2); */

                return response()->json([
                    'status' => 200,
                    'count' => $data_check_list->count()
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

    public function save_check_list_historry_pad(Request $request)
    {
        $table_result = 'App\\Models\\' .  $request->input('table');
        $table_result_detail = 'App\\Models\\' . $request->input('table_2');
        $master_line = 'App\\Models\\' . $request->input('groups') . '_master_line';
        $check_list_master = 'App\\Models\\' . $request->input('groups') . '_check_list_detail';
        $check_list = ($request->input('check_list') == '---') ? null : $request->input('check_list');
        $cong_doan = ($request->input('cong_doan') == '---') ? null : $request->input('cong_doan');
        $line_type = ($request->input('line_type') == '---') ? null : $request->input('line_type');
        $line = ($request->input('line') == '---') ? null : $request->input('line');
        $shift = ($request->input('shifts') == '---') ? null : $request->input('shifts');
        $groups = ($request->input('groups') == '---') ? null : $request->input('groups');
        $phan_loai = ($request->input('phan_loai') == '---') ? null : $request->input('phan_loai');
        $date_form = $request->input('date');
        if ($request->ajax()) {
            if (class_exists($table_result)) {
                $data = $table_result::where('groups', 'LIKE', '%' . $groups . '%')
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->where('date', $date_form)
                    ->pluck('id_check_list_line')->toArray();
                $data = array_unique($data);

                $data_check_list = $master_line::whereNotIn('id', $data)
                    ->where('groups', 'LIKE', '%' . $groups . '%')
                    ->where('check_list', 'LIKE', '%' . $check_list . '%')
                    ->where('cong_doan', 'LIKE', '%' . $cong_doan . '%')
                    ->where('phan_loai', 'LIKE', '%' . $phan_loai . '%')
                    ->where('line_type', 'LIKE', '%' . $line_type . '%')
                    ->where('line', 'LIKE', '%' . $line . '%')
                    ->where('shifts', 'LIKE', '%' .  $shift . '%')
                    ->get();


                foreach ($data_check_list as $item) {
                    if ($item->phan_loai == 'EQM') {
                        $nhan_vien = nhan_vien_check_list::where('groups', $groups)
                            ->where('phan_loai', $item->phan_loai)
                            ->inRandomOrder()->first();
                    } else {
                        $nhan_vien = nhan_vien_check_list::where('groups', $groups)
                            ->where('phan_loai', 'production')
                            ->where('line_type', $item->line_type)
                            ->inRandomOrder()->first();
                    }


                    $check_list_record = $table_result::create([
                        'id_check_list_line' => $item->id,
                        'groups' => $item->groups,
                        'check_list' => $item->check_list,
                        'cong_doan' => $item->cong_doan,
                        'line_type' => $item->line_type,
                        'phan_loai' => $item->phan_loai,
                        'line' => $item->line,
                        'shifts' => $item->shifts,
                        'name' => $nhan_vien->name . ' - ' . $nhan_vien->gen,
                        'part' => $nhan_vien->part,
                        'status' => 'OK',
                        'problem' => '',
                        'process' => '',
                        'tinh_trang' => 'ON',
                        'date' => $date_form,
                    ]);
                    $id_phan_loai = $item->id_phan_loai;
                    $check_list_detail =  $check_list_master::where('id_phan_loai', $id_phan_loai)->get();

                    foreach ($check_list_detail as $item_detail) {

                        $table_result_detail::create([
                            'id_check_list' => $check_list_record->id,
                            'groups' => $item->groups,
                            'check_list' => $item->check_list,
                            'cong_doan' => $item->cong_doan,
                            'line_type' => $item->line_type,
                            'phan_loai' => $item->phan_loai,
                            'comment' => $item_detail->comment,
                            'line' => $item->line,
                            'shifts' => $item->shifts,
                            'name' => $nhan_vien->name . ' - ' . $nhan_vien->gen,
                            'part' => $nhan_vien->name,
                            'status' => 'OK',
                            'problem' => '',
                            'process' => '',
                            'tinh_trang' => 'ON',
                            'date' => $date_form,
                        ]);
                    }
                }
                return response()->json([
                    'status' => 200,
                    'count' => $data_check_list->count()
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
    public function save_edit_check_list(Request $request)
    {
        $data = $request->all();
        foreach ($data as $item) {
            $check_list = check_list_detail::updateOrCreate($item);
        }

        $id_check_list = $check_list->id;

        return response()->json([
            'id' =>  $id_check_list,
            'status' => 200,
            'message' => 'Register Successfully.'
        ]);
    }

    public function save_check_list_detail(Request $request, $table)
    {
        $data = $request->all();
        $table_result_detail = 'App\\Models\\' . $table;
        foreach ($data as $item) {
            $table_result_detail::create($item);
        }

        return response()->json([
            'status' => 200,

        ]);
    }

    public function delete_row_search(Request $request)
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

    public function delete_row_edit(Request $request)
    {
        $table_1 = 'App\Models\\' . $request->input('table1');
        $row_id_delete = $request->input('rowId');
        if ($request->ajax()) {
            if (class_exists($table_1)) {

                $table_1::whereIn('id', $row_id_delete)->delete();
                return response()->json([
                    'status' => 200,

                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function new_row(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $id_phan_loai = $request->input("id");
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);

                $models = new $table;
                $models->id_phan_loai = $id_phan_loai;
                $models->save();
                $data = $table::where('id_phan_loai', $id_phan_loai)->select($colums)->get();
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
}