<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\Model_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class UpdateDataWarehouseController extends Controller
{


    //
    public function data_model()
    {
        return view('ilsung.WareHouse.pages.update_master.data-model');
    }

    public function data_sanpham()
    {
        return view('ilsung.WareHouse.pages.update_master.data-sanpham');
    }

    public function data_kho()
    {
        return view('ilsung.WareHouse.pages.update_master.data-kho');
    }

    public function show_data_table(Request $request)
    {
        if($request->input('table')=="Model_master"){
            $table = 'App\Models\\' . $request->input('table'); 
        }else{
            $table = 'App\Models\WareHouse\\' . $request->input('table');
        }
        if ($request->ajax()) {
            if (class_exists($table)) {
                $data = $table::all();
                $colum = array_keys($data->first()->getAttributes());
                $colums = array_diff($colum, ['created_at', 'updated_at']);
                $data = $table::select($colums)->orderBy('id', 'asc')->get();

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
    public function update_table(Request $request)
    {
        // Xác thực request
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'Dữ liệu không hợp lệ.',
            ]);
        }

        // Lấy model
        $modelName = $request->input('id');
        $allowedModels = ['Product', 'Warehouse', 'Model_master']; // Danh sách model hợp lệ
        if (!in_array($modelName, $allowedModels)) {
            return response()->json([
                'status' => 400,
                'error' => 'Model không hợp lệ.',
            ]);
        }
        if($modelName=="Model_master"){
            $table = 'App\Models\\' . $modelName;

        }else{
            $table = 'App\Models\WareHouse\\' . $modelName;

        }
     

        // Lưu file CSV
        if (Storage::exists("csv/data.csv")) {
            Storage::delete("csv/data.csv");
        }
        $path = $request->file('csv_file')->storeAs('csv', 'data.csv');
        $path_2 = storage_path("app/" . $path);

        try {
            // Đọc file CSV
            $csv = Reader::createFromPath($path_2, 'r');
            $csv->setHeaderOffset(0);

            // Cập nhật dữ liệu
            foreach ($csv as $record) {
                if (!isset($record['id'])) {
                    continue; // Bỏ qua nếu thiếu 'id'
                }

                $table::updateOrCreate(
                    ['id' => $record['id']],
                    $record
                );
            }

            // Xóa file sau khi xử lý
            Storage::delete($path);

            return redirect()->back()->with('success', 'Cập nhật dữ liệu thành công.');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }

    // {
    //     $modelName = $request->input('id');
    //     $allowedModels = ['Product', 'Warehouse', 'Model_master']; // Danh sách các model hợp lệ

    //     if (!in_array($modelName, $allowedModels)) {
    //         return response()->json([
    //             'status' => 400,
    //             'error' => 'Model không hợp lệ.',
    //         ]);
    //     }

    //     $table = 'App\Models\\' . $modelName;

    //     // dd($table);
    //     $validator = Validator::make($request->all(), [
    //         'csv_file' => [
    //             'required',
    //         ],
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 400,
    //         ]);
    //     } else {

    //         if (Storage::exists("csv/data.csv")) {
    //             Storage::delete("csv/data.csv");
    //         };
    //         $path = $request->file('csv_file')->storeAs('csv', 'data.csv');
    //         $path_2 = str_replace('\\', '/', storage_path("app/" . $path));
    //         $csv = Reader::createFromPath($path_2, 'r');
    //         $csv->setHeaderOffset(0);

    //         foreach ($csv as $record) {
    //             // dd($record);
    //             $table::updateOrCreate(
    //                 ['id' => $record['id']],
    //                 $record
    //             );
    //         }
    //         Storage::delete($path);
    //         return redirect()->back()->with('success', 'update dữ liệu thành công');
    //     }
    // }

    public function delete_data_row_table(Request $request)
    {
        if($request->input('table')=="Model_master"){
            $table = 'App\Models\\' . $request->input('table'); 
        }else{
            $table = 'App\Models\WareHouse\\' . $request->input('table');
        }
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
        if($request->input('table')=="Model_master"){
            $table = 'App\Models\\' . $request->input('table'); 
        }else{
            $table = 'App\Models\WareHouse\\' . $request->input('table');
        }
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
                    'success' =>'Cập nhật dữ liệu thành công.'
                ]);
            }
            return response()->json([
                'status' => 404,
                'error' => 'Cập nhập data bị lỗi'
            ]);
        }
        return abort(404);
    }

    public function data_machine_master(Request $request)
    {
        $machine = Machine_master::all();
        $line = line::all();
        $model = Model_master::all();
        $khung_check = Checklist_item::distinct()->pluck('khung_check');

        return response()->json(
            [
                'machine' => $machine,
                'line' => $line,
                'model' => $model,
                'khung_check' => $khung_check
            ]
        );
    }

    public function data_item_master(Request $request)
    {
        $Machine = $request->input("Machine");
        $list_item_checklist = Checklist_master::where('Machine', $Machine)->get();
        return response()->json(
            [
                'checklist_item' => $list_item_checklist,
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
        $Shift = ($request->input('Shift') == 'All') ? null : $request->input('Shift');


        if ($request->ajax()) {
            if (class_exists($table)) {

                $data = $table::where('Machine', 'LIKE', '%' . $Machine . '%')
                    ->where('Shift', 'LIKE', '%' . $Shift . '%')
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
