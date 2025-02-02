<?php

namespace App\Http\Controllers\WareHouse;

use App\Exports\ErrorExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Imports\WarehouseImport;
use App\Models\Model_master;
use App\Models\WareHouse\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UpdateDataWarehouseController extends Controller
{


    //
    public function data_model()
    {
        return view('srtech.WareHouse.pages.update_master.data-model');
    }

    public function data_sanpham()
    {
        return view('srtech.WareHouse.pages.update_master.data-sanpham');
    }

    public function data_kho()
    {
        return view('srtech.WareHouse.pages.update_master.data-kho');
    }

    public function show_data_table(Request $request)
    {
        if ($request->input('table') == "Model_master" || $request->input('table') == "User") {
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
        // Nhận tham số từ frontend (DataTable)
        $type = ($request->input('Type') == 'All') ? null : $request->input('Type');
        $model = ($request->input('Model') == 'All') ? null : $request->input('Model');
        $id_sp = $request->input('ID_SP');


        $query = Product::query();

        // Chỉ lọc theo Type nếu Type không phải là null

        if (!empty($id_sp)) {
            $query->where('ID_SP', $id_sp);
        } else {
            if ($type !== null) {
                $query->where('Type', $type);
            }

            // Chỉ lọc theo Model nếu Model không phải là null
            if ($model !== null) {
                $query->where('Model', $model);
            }
        }



        $filteredRecords = (clone $query)->count();

        // Tổng số bản ghi không lọc
        $totalRecords = Product::count();

        // Lấy tham số phân trang
        $start = (int)$request->input('start', 0);
        $length = (int)$request->input('length', 10);

        // Lấy dữ liệu theo phân trang
        $products = $query->skip($start)->take($length)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'error' => 'Không có sản phẩm nào được tìm thấy.',
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => []
            ]);
        }

        // Trả về kết quả
        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products,
            'Success' => 'OK',
        ]);
    }
    public function store_products(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'Type' => 'required|string',
            // 'ID_SP' => 'nullable|string',
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
                if ($type != $product->Type) {
                    $ID_SP = $this->created_ID_SP($type);
                } else {
                    $ID_SP = $request->input('ID_SP');
                }
                $product->update([
                    'Type' => $type,
                    'Model' => $modelName,
                    'ID_SP' => $ID_SP,
                    'name' => $request->input('name'),
                    'Code_Purchase' => $request->input('Code_Purchase'),
                    'stock_limit' => $request->input('stock_limit'),
                    'vendor' => $request->input('vendor'),
                    'version' => $request->input('version'),
                    'Image' => $imageName, // Xử lý ảnh nếu có
                ]);
                return redirect()->back()->with('success', 'Product updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Product not found.');
            }
        } else {

            $ID_SP = $this->created_ID_SP($type);

            // Tạo mới bản ghi sản phẩm
            $product = Product::create([
                'ID_SP' => $ID_SP,
                'Type' => $type,
                'Model' => $modelName,
                'name' => $request->input('name'),
                'Code_Purchase' => $request->input('Code_Purchase'),
                'stock_limit' => $request->input('stock_limit'),
                'vendor' => $request->input('vendor'),
                'version' => $request->input('version'),
                'Image' => $this->handleImageUpload($request), // Xử lý ảnh nếu có
            ]);

            return redirect()->back()->with('success', 'Product saved successfully!');
        }
    }

    function created_ID_SP($type)
    {
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
        return $newId;
    }

    // Hàm xử lý việc upload ảnh
    protected function handleImageUpload(Request $request)
    {
        if ($request->hasFile('Image')) {
            $type = $request->input('Type');
            $name = $this->created_ID_SP($type);
            $imageName =  $name . '.' . $request->Image->extension();
            $request->Image->move(public_path('SR-TECH/image/warehouse'), $imageName);
            return 'SR-TECH/image/warehouse/' . $imageName;
        }
        return ''; // Nếu không có ảnh, trả về chuỗi rỗng
    }

    public function downloadTemplate($file_name)
    {
        // Đường dẫn file trong thư mục public
        $filePath = public_path('sr-tech/templates/' . $file_name);

        // Kiểm tra xem file có tồn tại không
        if (!file_exists($filePath)) {
            // Trả về lỗi nếu file không tồn tại
            return response()->json(['error' => 'File mẫu không tồn tại'], 404);
        }

        // Trả về file cho người dùng tải về
        return response()->download($filePath, $file_name);
    }



    public function delete_data_row_table(Request $request)
    {
        if ($request->input('table') == "Model_master") {
            $table = 'App\Models\\' . $request->input('table');
        } else {
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

    public function updateFromExcel_kho(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        $errors = []; // Mảng chứa các dòng lỗi

        try {
            // Chuyển đổi dữ liệu từ file Excel thành mảng
            $data = Excel::toArray(new WarehouseImport, $request->file('excel_file'));

            // Kiểm tra dữ liệu đã được chuyển thành mảng chưa
            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    if ($index == 0) {
                        continue;  // Bỏ qua dòng tiêu đề
                    }

                    // Kiểm tra các trường cần thiết (category, name)
                    $name = isset($row[0]) ? trim($row[0]) : '';
                    $location = isset($row[1]) ? trim($row[1]) : '';
                    $status = isset($row[2]) ? trim($row[2]) : '';  // remark có thể có hoặc không
                    // Kiểm tra giá trị trống
                    if (empty($location) || empty($name) || empty($status)) {
                        $errors[] = [
                            'row' => $index + 1,  // Dòng bị lỗi
                            'error' => 'Dữ liệu thiếu thông tin quan trọng',
                            'data' => $row,
                        ];
                        continue; // Bỏ qua dòng này nếu thiếu dữ liệu quan trọng
                    }

                    // Kiểm tra xem bản ghi đã tồn tại chưa
                    $existingRecord = DB::table('warehouses')
                        ->where('location', $location)
                        ->where('status', $status)
                        ->where('name', $name)
                        ->first();

                    if ($existingRecord) {
                        // Nếu đã tồn tại thì cập nhật bản ghi
                        DB::table('warehouses')
                            ->where('id', $existingRecord->id)
                            ->update([
                                'location' => $location,
                                'name' => $name,
                                'status' => $status,
                            ]);
                    } else {
                        // Nếu chưa tồn tại thì thêm mới bản ghi
                        DB::table('warehouses')
                            ->insert([
                                'location' => $location,
                                'name' => $name,
                                'status' => $status,
                            ]);
                    }
                }

                // Nếu có lỗi, xuất file Excel chứa lỗi
                if (!empty($errors)) {
                    return Excel::download(new ErrorExport($errors), 'errors.xlsx');
                }

                return redirect()->back()->with('success', 'Cập nhật dữ liệu thành công từ file Excel.');
            } else {
                return redirect()->back()->with('error', 'Dữ liệu trong file không hợp lệ.');
            }
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý file: ' . $e->getMessage());
        }
    }


    public function updateFromExcel_product(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $errors = []; // Mảng chứa các lỗi
        try {
            // Chuyển file Excel thành mảng
            $data = Excel::toArray(new ProductImport, $request->file('excel_file'));

            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    if ($index == 0) {
                        continue; // Bỏ qua dòng tiêu đề
                    }

                    // Lấy các cột từ file Excel
                    $name = $row[1] ?? null;
                    $type = $row[0] ?? null; // SKU là khóa chính hoặc duy nhất
                    $ID_SP = $row[3] ?? null;

                    // Kiểm tra dữ liệu cần thiết
                    if (empty($name) || empty($type)) {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Dữ liệu thiếu trường bắt buộc (name hoặc SKU)',
                            'data' => $row,
                        ];
                        continue;
                    }

                    // Kiểm tra xem sản phẩm đã tồn tại chưa
                    $existingProduct = DB::table('products')
                        ->where('ID_SP', $ID_SP)
                        ->first();

                    if ($existingProduct) {
                        // Cập nhật bản ghi nếu đã tồn tại
                        DB::table('products')
                            ->where('ID_SP', $ID_SP)
                            ->update([
                                'Type'        => $row[0] ?? null,  // Cột đầu tiên là name
                                'name'        => $row[1] ?? null,  // Cột Type
                                'Code_Purchase'     => $row[2] ?? null,  // Cột Part_ID
                                'ID_SP' => $ID_SP ?? null, // Cột Code_Purchase
                                'Part_ID'       => $row[4] ?? null,  // Cột ID_SP
                                'Model'       => $row[5] ?? null,
                                'vendor'      => $row[6] ?? null,
                                'version'     => $row[7] ?? null,
                                'stock_limit' => $row[8] ?? null,
                                'Image'       => $row[9] ?? null,
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Thêm mới bản ghi
                        $ID_SP = $this->created_ID_SP($type);
                        DB::table('products')->insert([
                            'Type'        => $row[0] ?? null,  // Cột đầu tiên là name
                            'name'        => $row[1] ?? null,  // Cột Type
                            'Code_Purchase'     => $row[2] ?? null,  // Cột Part_ID
                            'ID_SP' =>   $ID_SP, // Cột Code_Purchase
                            'Part_ID'       => $row[4] ?? null,  // Cột ID_SP
                            'Model'       => $row[5] ?? null,
                            'vendor'      => $row[6] ?? null,
                            'version'     => $row[7] ?? null,
                            'stock_limit' => $row[8] ?? null,
                            'Image'       => $row[9] ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Nếu có lỗi, trả file Excel lỗi
                if (!empty($errors)) {
                    return Excel::download(new ErrorExport($errors), 'errors.xlsx');
                }

                return redirect()->back()->with('success', 'Cập nhật dữ liệu thành công.');
            }

            return redirect()->back()->with('error', 'File Excel không chứa dữ liệu hợp lệ.');
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function check_list_masster(Request $request)
    {
        $model = Model_master::all();
        return response()->json(
            [
                'model' => $model,
            ]
        );
    }
}
