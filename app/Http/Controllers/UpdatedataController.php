<?php

namespace App\Http\Controllers;

use App\Models\line;
use App\Models\Machine_master;
use App\Models\Model_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UpdatedataController extends Controller
{

    public function data_model()
    {
        return view('ilsung.pages.update_master.data-model');
    }

    public function data_machine()
    {
        return view('ilsung.pages.update_master.data-machine');
    }

    public function data_machine_list()
    {
        return view('ilsung.pages.update_master.data-machine-list');
    }

    public function data_checklist_master()
    {
        return view('ilsung.pages.update_master.data-checklist-master');
    }

    public function data_checklist_item()
    {
        return view('ilsung.pages.update_master.data-checklist-item');
    }

    public function data_line()
    {
        return view('ilsung.pages.update_master.data-line');
    }
    public function index()
    {
        return view('ilsung.pages.update_master.index-data');
    }

    public function show_data_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);

                // $models = new $table;
                // foreach ($colum as $column) {
                //     $models->$column = '';
                // }
                // $models->save();
                $data = $table::select($colums)->orderBy('id', 'DESC')->get();

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

    public function delete_data_row_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $id = $request->input('id_row');
        if ($request->ajax()) {
            if (class_exists($table)) {
                $table::where('id', $id)->delete();
                $data = $table::all();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function add_data_row_table(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $models = new $table;
        $tables = $models->getTable();
        $id = $request->input('id', null);


        $columns = Schema::getColumnListing($tables);
        $columns = array_diff($columns, ['id', 'table', 'created_at', 'updated_at']);
        $data = $request->only($columns);
        if ($request->ajax()) {
            if (class_exists($table)) {
                if (is_null($id)) {
                    $table::create($data);  // Thêm mới dữ liệu vào bảng
                } else {
                    // Nếu có ID, thực hiện cập nhật bản ghi có ID
                    $table::where('id', $id)->update($data);  // Cập nhật dữ liệu cho bản ghi có ID
                }
                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function data_machine_master(Request $request)
    {
        $machine = Machine_master::all();
        $line = line::all();
        $model = Model_master::all();
        return response()->json(
            [
                'machine' => $machine,
                'line' => $line,
                'model' => $model,
            ]
        );
    }


    public function show_data_table_machine(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');
        $line = ($request->input('line') == 'All') ? null : $request->input('line');
        $Code_machine = ($request->input('Code_machine') == '') ? null : $request->input('Code_machine');
        $Machine = ($request->input('Machine') == 'All') ? null : $request->input('Machine');
        $Status = ($request->input('Status') == 'All') ? null : $request->input('Status');

        if ($request->ajax()) {
            if (class_exists($table)) {

                $data = $table::where('Locations', 'LIKE', '%' . $line . '%')
                    ->where('Code_machine', 'LIKE', '%' . $Code_machine . '%')
                    ->where('Machine', 'LIKE', '%' . $Machine . '%')
                    ->where('Status', 'LIKE', '%' . $Status . '%')
                    ->orderBy('id', "desc")
                    ->get();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function show_data_table_checklist_master(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');

        $Machine = ($request->input('Machine') == 'All') ? null : $request->input('Machine');


        if ($request->ajax()) {
            if (class_exists($table)) {

                $data = $table::where('Machine', 'LIKE', '%' . $Machine . '%')
                    ->orderBy('id', "desc")
                    ->get();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function show_data_table_checklist_item(Request $request)
    {
        $table = 'App\Models\\' . $request->input('table');

        $Machine = ($request->input('Machine') == 'All') ? null : $request->input('Machine');


        if ($request->ajax()) {
            if (class_exists($table)) {

                $data = $table::where('Machine', 'LIKE', '%' . $Machine . '%')
                    ->orderBy('id', "desc")
                    ->get();

                return response()->json([
                    'data' => $data,
                    'status' => 200,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }
}
