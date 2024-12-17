<?php

namespace App\Http\Controllers\WareHouse;

use App\Exports\ErrorExport;
use App\Http\Controllers\Controller;
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

    // Hàm xử lý việc upload ảnh
    protected function handleImageUpload(Request $request)
    {
        if ($request->hasFile('Image')) {
            $imageName = time() . '.' . $request->Image->extension();
            $request->Image->move(public_path('storage/photos/Jig_Des_Images'), $imageName);
            return 'storage/photos/Jig_Des_Images/' . $imageName;
        }
        return ''; // Nếu không có ảnh, trả về chuỗi rỗng
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

                    // dd($row);
                    // dd($category, $name, $remark);


                    // Kiểm tra giá trị trống
                    if (empty($category) || empty($name)) {
                        $errors[] = [
                            'row' => $index + 1,  // Dòng bị lỗi
                            'error' => 'Dữ liệu thiếu thông tin quan trọng',
                            'data' => $row,
                        ];
                        continue; // Bỏ qua dòng này nếu thiếu dữ liệu quan trọng
                    }

                    // Kiểm tra xem bản ghi đã tồn tại chưa
                    $existingRecord = DB::table('errors_list')
                        ->where('location', $location)
                        ->where('status', $status)
                        ->where('name', $name)
                        ->first();

                    if ($existingRecord) {
                        // Nếu đã tồn tại thì cập nhật bản ghi
                        DB::table('errors_list')
                            ->where('id', $existingRecord->id)
                            ->update([
                                'location' => $location,
                                'name' => $name,
                                'status' => $status,
                            ]);
                    } else {
                        // Nếu chưa tồn tại thì thêm mới bản ghi
                        DB::table('errors_list')
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
}
