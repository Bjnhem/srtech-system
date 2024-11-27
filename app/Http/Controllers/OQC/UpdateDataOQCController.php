<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Model_master;
use App\Models\OQC\Plan;
use App\Models\WareHouse\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Yajra\DataTables\DataTables;
use App\Imports\PlansImport;
use Maatwebsite\Excel\Facades\Excel;

class UpdateDataOQCController extends Controller
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
        if ($request->input('table') == "Model_master") {
            $table = 'App\Models\\' . $request->input('table');
        } else {
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
        if ($modelName == "Model_master") {
            $table = 'App\Models\\' . $modelName;
        } else {
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
    public function showData(Request $request)
    {
        $date = $request->input('Date');
        $shift = ($request->input('Shift') == 'All') ? null : $request->input('Shift');
        $line = ($request->input('Line') == 'All') ? null : $request->input('Line');

        $query = Plan::query();

        if (!empty($date)) {
            $query->whereDate('date', $date);
        }
        if ($shift !== null) {
            $query->where('shift', $shift);
        }
        if ($line !== null) {
            $query->where('line', $line);
        }

        $filteredRecords = $query->count();
        $totalRecords = Plan::count();

        $start = (int)$request->input('start', 0);
        $length = (int)$request->input('length', 10);

        $products = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products
        ]);
    }


    public function store_products(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'Type' => 'required|string',
            'ID_SP' => 'nullable|string',
            'Model' => 'nullable|string',
            'name' => 'nullable|string',
            'Code_Purchase' => 'nullable|string',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Get the ID from the form (hidden input)
        $id = $request->input('id');
        $type = $request->input('Type');
        $modelId = $request->input('Model');
        $modelName = Model_master::find($modelId)->model;
        // Kiểm tra nếu ID đã có trong cơ sở dữ liệu
        if ($id) {
            // Nếu có ID, tìm và cập nhật bản ghi
            $product = Product::find($id);  // Tìm sản phẩm theo ID

            if ($product) {
                $imageName = $product->Image;
                // Cập nhật thông tin sản phẩm
                if ($request->hasFile('Image')) {
                    // Nếu có ảnh mới, tải lên ảnh mới
                    $imageName = $this->handleImageUpload($request);
                }
                $product->update([
                    'Type' => $type,
                    'Model' => $modelName,
                    'ID_SP' => $request->input('ID_SP'),
                    'name' => $request->input('name'),
                    'Code_Purchase' => $request->input('Code_Purchase'),
                    'stock_limit' => $request->input('stock_limit'),
                    'Image' => $imageName, // Xử lý ảnh nếu có
                ]);
                return redirect()->back()->with('success', 'Product updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Product not found.');
            }
        } else {
            // Nếu không có ID, tạo mới sản phẩm
            // Generate new ID_SP
            $lastId = Product::where('Type', $type)->latest('ID_SP')->first(); // Get the latest ID_SP for the selected Type

            $newId = '';
            if ($lastId) {
                // Nếu có sản phẩm trước đó, tăng giá trị ID_SP
                preg_match('/(\d+)$/', $lastId->ID_SP, $matches);
                $newNumber = intval($matches[0]) + 1;
                $newId = "EQM-" . strtoupper($type) . "-" . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Nếu không có sản phẩm, tạo ID_SP bắt đầu từ EQM-TYPE-10000
                $newId = "EQM-" . strtoupper($type) . "-10000";
            }

            // Tạo mới bản ghi sản phẩm
            $product = Product::create([
                'ID_SP' => $newId,
                'Type' => $type,
                'Model' => $modelName,
                'name' => $request->input('name'),
                'Code_Purchase' => $request->input('Code_Purchase'),
                'stock_limit' => $request->input('stock_limit'),
                'Image' => $this->handleImageUpload($request), // Xử lý ảnh nếu có
            ]);

            return redirect()->back()->with('success', 'Product saved successfully!');
        }
    }

    public function store_plan(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'date' => 'required|date',
            'shift' => 'required|string',
            'line' => 'required|string',
            'model' => 'required|string',
            'prod' => 'required|integer',
            'a' => 'nullable|integer',
            'b' => 'nullable|integer',
            'c' => 'nullable|integer',
            'd' => 'nullable|integer',
            'e' => 'nullable|integer',
        ]);

        // Get the ID from the form (hidden input)
        $id = $request->input('id');

        // Kiểm tra nếu ID đã có trong cơ sở dữ liệu
        if ($id) {
            // Nếu có ID, tìm và cập nhật bản ghi
            $plan = Plan::find($id);  // Tìm kế hoạch theo ID

            if ($plan) {
                // Cập nhật thông tin kế hoạch
                $plan->update($request->all());
                return redirect()->back()->with('success', 'Kế hoạch được cập nhật thành công!');
            } else {
                return redirect()->back()->with('error', 'Không tìm thấy kế hoạch.');
            }
        } else {
            // Nếu không có ID, tạo mới kế hoạch
            Plan::create($request->all());
            return redirect()->back()->with('success', 'Kế hoạch được lưu thành công!');
        }
    }

    public function delete_data_row_table(Request $request)
    {
        if ($request->input('table') == "errors_list") {
            $table = 'App\Models\\' . $request->input('table');
        } else {
            $table = 'App\Models\OQC\\' . $request->input('table');
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
        if ($request->input('table') == "Model_master") {
            $table = 'App\Models\\' . $request->input('table');
        } else {
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
                    'success' => 'Cập nhật dữ liệu thành công.'
                ]);
            }
            return response()->json([
                'status' => 404,
                'error' => 'Cập nhập data bị lỗi'
            ]);
        }
        return abort(404);
    }


    public function downloadTemplate()
    {
        $filePath = 'templates/production_plan_form.xlsx'; // Đường dẫn file mẫu
        if (!Storage::exists($filePath)) {
            return response()->json(['error' => 'File mẫu không tồn tại'], 404);
        }
        return Storage::download($filePath, 'production_plan_template.xlsx');
    }

    public function updateFromExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new PlansImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Cập nhật kế hoạch thành công từ file Excel.');
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý file: ' . $e->getMessage());
        }
    }
}
