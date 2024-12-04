<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OQC\Plan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Yajra\DataTables\DataTables;
use App\Imports\PlansImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Exports\ErrorExport;
use App\Imports\ErrorListImport;
use App\Models\line;
use App\Models\Model_master;
use App\Models\OQC\ErrorList;
use App\Models\OQC\LineLoss;
use Illuminate\Database\Eloquent\Model;


class UpdateDataOQCController extends Controller
{

    //
    public function data_model()
    {
        return view('ilsung.OQC.pages.update_master.data-model');
    }

    public function data_line()
    {
        return view('ilsung.OQC.pages.update_master.data-line');
    }



    // controller loss
    public function data_loss()
    {
        return view('ilsung.OQC.pages.update_master.data-loss');
    }

    public function showData_loss(Request $request)
    {
        $category = $request->input('category');

        $query = ErrorList::query();

        if ($category !== "All") {
            $query->where('category', $category);
        }
        $filteredRecords = $query->count();
        $totalRecords = ErrorList::count();

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $products = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products
        ]);
    }

    public function showData_item()
    {

        $category = ErrorList::distinct()->pluck('category');
        return response()->json([
            'category' => $category
        ]);
    }

    public function updateFromExcel_loss(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        $errors = []; // Mảng chứa các dòng lỗi

        try {
            // Chuyển đổi dữ liệu từ file Excel thành mảng
            $data = Excel::toArray(new ErrorListImport, $request->file('excel_file'));

            // Kiểm tra dữ liệu đã được chuyển thành mảng chưa
            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    if ($index == 0) {
                        continue;  // Bỏ qua dòng tiêu đề
                    }

                    // Kiểm tra các trường cần thiết (category, name)
                    $category = isset($row[0]) ? trim($row[0]) : '';
                    $name = isset($row[1]) ? trim($row[1]) : '';
                    $remark = isset($row[2]) ? trim($row[2]) : '';  // remark có thể có hoặc không

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
                        ->where('category', $category)
                        ->where('name', $name)
                        ->first();

                    if ($existingRecord) {
                        // Nếu đã tồn tại thì cập nhật bản ghi
                        DB::table('errors_list')
                            ->where('id', $existingRecord->id)
                            ->update([
                                'category' => $category,
                                'name' => $name,
                                'remark' => $remark,
                            ]);
                    } else {
                        // Nếu chưa tồn tại thì thêm mới bản ghi
                        DB::table('errors_list')
                            ->insert([
                                'category' => $category,
                                'name' => $name,
                                'remark' => $remark,
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



    // controller plan

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

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $products = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products
        ]);
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
                // Lấy các time_slot từ form
                $timeSlots = ['a', 'b', 'c', 'd', 'e'];

                // Lặp qua các time_slot và cập nhật prod_qty trong bảng line_losses
                foreach ($timeSlots as $timeSlot) {
                    if ($request->has($timeSlot)) {
                        // Cập nhật giá trị prod_qty cho từng time_slot
                        LineLoss::where('plan_id', $plan->id)
                            ->where('time_slot', $timeSlot)
                            ->update([
                                'prod_qty' => $request->input($timeSlot) // Cập nhật prod_qty theo giá trị từ form
                            ]);
                    }
                }

                $this->calculateSummary($plan->date); // Chỉ tính toán lại cho ngày cụ thể


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


    public function calculateSummary($specificDate = null)
    {
        if (!$specificDate) {
            return; // Không làm gì nếu không có ngày cụ thể
        }

        // Xóa dữ liệu cũ trong bảng `line_losses_summary` chỉ cho ngày cụ thể
        DB::table('line_losses_summary')->whereDate('date', $specificDate)->delete();

        // Tổng hợp dữ liệu cho ngày cụ thể
        $prodData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id')
            ->select(
                'plans.model',
                DB::raw("'Prod [ea]' as item"),
                DB::raw('DATE(plans.date) as date'),
                DB::raw('SUM(DISTINCT plans.prod) as value')
            )
            ->whereDate('plans.date', $specificDate)
            ->groupBy('plans.model', DB::raw('DATE(plans.date)'))
            ->get();

        $ngData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id')
            ->select(
                'plans.model',
                DB::raw("'Q\'ty NG [ea]' as item"),
                DB::raw('DATE(plans.date) as date'),
                DB::raw('SUM(line_losses.NG_qty) as value')
            )
            ->whereDate('plans.date', $specificDate)
            ->groupBy('plans.model', DB::raw('DATE(plans.date)'))
            ->get();

        $rateData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id')
            ->select(
                'plans.model',
                DB::raw("'Rate [%]' as item"),
                DB::raw('DATE(plans.date) as date'),
                DB::raw('CASE WHEN SUM(DISTINCT plans.prod) > 0 THEN ROUND((SUM(line_losses.NG_qty) / SUM(DISTINCT plans.prod)) * 100, 2) ELSE 0 END as value')
            )
            ->whereDate('plans.date', $specificDate)
            ->groupBy('plans.model', DB::raw('DATE(plans.date)'))
            ->get();

        // Kết hợp dữ liệu và thêm vào bảng `line_losses_summary`
        $combinedData = collect([$prodData, $ngData, $rateData])->collapse();

        foreach ($combinedData as $data) {
            DB::table('line_losses_summary')->insert([
                'model' => $data->model,
                'item' => $data->item,
                'year' => date('Y', strtotime($data->date)),
                'month' => date('m', strtotime($data->date)),
                'week' => date('W', strtotime($data->date)),
                'date' => $data->date,
                'value' => $data->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function updateFromExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        $errors = []; // Mảng chứa các dòng lỗi
        try {
            // Chuyển đổi dữ liệu từ file Excel thành mảng
            $data = Excel::toArray(new PlansImport, $request->file('excel_file'));

            // Kiểm tra dữ liệu đã được chuyển thành mảng chưa
            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    // Kiểm tra giá trị trống
                    if (empty($row['shift']) || empty($row['line'])) {
                        $errors[] = [
                            'row' => $index + 1,  // Dòng bị lỗi
                            'error' => 'Shift hoặc Line bị thiếu',
                            'data' => $row,
                        ];
                        continue; // Bỏ qua dòng này nếu thiếu dữ liệu quan trọng
                    }

                    // Chuyển đổi giá trị ngày tháng từ số (Excel) sang định dạng ngày tháng chuẩn
                    try {
                        $date = Date::excelToDateTimeObject($row['date']);
                        $formattedDate = $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Ngày không hợp lệ',
                            'data' => $row,
                        ];
                        continue;
                    }

                    // Làm sạch dữ liệu và loại bỏ dấu phẩy trong số liệu
                    $prod = str_replace(',', '', $row['prod']);
                    $a = isset($row['a']) && ($row['a'] !== null && $row['a'] !== 0) ? str_replace(',', '', $row['a']) : 0;
                    $b = isset($row['b']) && ($row['b'] !== null && $row['b'] !== 0) ? str_replace(',', '', $row['b']) : 0;
                    $c = isset($row['c']) && ($row['c'] !== null && $row['c'] !== 0) ? str_replace(',', '', $row['c']) : 0;
                    $d = isset($row['d']) && ($row['d'] !== null && $row['d'] !== 0) ? str_replace(',', '', $row['d']) : 0;
                    $e = isset($row['e']) && ($row['e'] !== null && $row['e'] !== 0) ? str_replace(',', '', $row['e']) : 0;

                    // Kiểm tra xem bản ghi đã tồn tại chưa
                    $existingRecord = DB::table('plans')
                        ->where('date', $formattedDate)
                        ->where('shift', $row['shift'])
                        ->where('line', $row['line'])
                        ->first();

                    if ($existingRecord) {
                        // Cập nhật bản ghi nếu đã tồn tại
                        DB::table('plans')
                            ->where('id', $existingRecord->id)
                            ->update([
                                'model' => $row['model'],
                                'prod' => $prod,
                                'a' => $a,
                                'b' => $b,
                                'c' => $c,
                                'd' => $d,
                                'e' => $e,
                            ]);
                    } else {
                        // Thêm mới bản ghi nếu chưa tồn tại
                        DB::table('plans')
                            ->insert([
                                'date' => $formattedDate,
                                'shift' => $row['shift'],
                                'line' => $row['line'],
                                'model' => $row['model'],
                                'prod' => $prod,
                                'a' => $a,
                                'b' => $b,
                                'c' => $c,
                                'd' => $d,
                                'e' => $e,
                            ]);
                    }
                }

                // Nếu có lỗi, xuất file Excel chứa lỗi
                if (!empty($errors)) {
                    return Excel::download(new ErrorExport($errors), 'errors.xlsx');
                }

                return redirect()->back()->with('success', 'Cập nhật kế hoạch thành công từ file Excel.');
            } else {
                return redirect()->back()->with('error', 'Dữ liệu trong file không hợp lệ.');
            }
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý file: ' . $e->getMessage());
        }
    }
    public function getdata_plan(Request $request)
    {

        $model = Model_master::all();
        $line = line::all();

        return response()->json([
            'model' => $model,
            'line' => $line,

        ]);
    }




    public function show_data_table(Request $request)
    {
        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan") {
            $table = 'App\Models\OQC\\' . $request->input('table');
        } else {
            $table = 'App\Models\\' . $request->input('table');
        }

        // $table = 'App\Models\\' . $request->input('table');
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
        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan") {
            $table = 'App\Models\OQC\\' . $request->input('table');
        } else {
            $table = 'App\Models\\' . $request->input('table');
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



    public function delete_data_row_table(Request $request)
    {
        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan") {
            $table = 'App\Models\OQC\\' . $request->input('table');
        } else {
            $table = 'App\Models\\' . $request->input('table');
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

        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan") {
            $table = 'App\Models\OQC\\' . $request->input('table');
        } else {
            $table = 'App\Models\\' . $request->input('table');
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


    public function downloadTemplate($file_name)
    {

        // Lấy đường dẫn file từ request


        $filePath = 'templates/' . $file_name;

        // Kiểm tra xem file có tồn tại không
        if (!$filePath || !Storage::exists($filePath)) {
            // Nếu file không tồn tại, trả về lỗi
            return response()->json(['error' => 'File mẫu không tồn tại'], 404);
        }

        // Trả về file mẫu cho người dùng tải về
        return Storage::download($filePath, $file_name);
    }

    // public function updateFromExcel(Request $request)
    // {
    //     $request->validate([
    //         'excel_file' => 'required|file|mimes:xlsx,xls',
    //     ]);

    //     try {
    //         // Chuyển đổi dữ liệu từ file Excel thành mảng
    //         $data = Excel::toArray(new PlansImport, $request->file('excel_file'));

    //         // Kiểm tra dữ liệu đã được chuyển thành mảng chưa
    //         if (is_array($data) && count($data) > 0) {
    //             foreach ($data[0] as $row) { // Dữ liệu Excel thường nằm trong mảng con thứ 0
    //                 // Chuyển đổi giá trị ngày tháng từ số (Excel) sang định dạng ngày tháng chuẩn
    //                 $date = Date::excelToDateTimeObject($row['date']);
    //                 $formattedDate = $date->format('Y-m-d');

    //                 // Làm sạch dữ liệu và loại bỏ dấu phẩy trong số liệu
    //                 $prod = str_replace(',', '', $row['prod']);
    //                 $a = str_replace(',', '', $row['a']);
    //                 $b = str_replace(',', '', $row['b']);
    //                 $c = str_replace(',', '', $row['c']);
    //                 $d = str_replace(',', '', $row['d']);
    //                 $e = str_replace(',', '', $row['e']);

    //                 // Kiểm tra xem bản ghi đã tồn tại chưa
    //                 $existingRecord = DB::table('plans') // Thay 'production_plans' bằng tên bảng thực tế
    //                     ->where('date', $formattedDate)
    //                     ->where('shift', $row['shift'])
    //                     ->where('line', $row['line'])
    //                     ->first();

    //                 if ($existingRecord) {
    //                     // Cập nhật bản ghi nếu đã tồn tại
    //                     DB::table('plans') // Thay 'production_plans' bằng tên bảng thực tế
    //                         ->where('id', $existingRecord->id)
    //                         ->update([
    //                             'model' => $row['model'],
    //                             'prod' => $prod,
    //                             'a' => $a,
    //                             'b' => $b,
    //                             'c' => $c,
    //                             'd' => $d,
    //                             'e' => $e,
    //                         ]);
    //                 } else {
    //                     // Thêm mới bản ghi nếu chưa tồn tại
    //                     DB::table('plans') // Thay 'production_plans' bằng tên bảng thực tế
    //                         ->insert([
    //                             'date' => $formattedDate,
    //                             'shift' => $row['shift'],
    //                             'line' => $row['line'],
    //                             'model' => $row['model'],
    //                             'prod' => $prod,
    //                             'a' => $a,
    //                             'b' => $b,
    //                             'c' => $c,
    //                             'd' => $d,
    //                             'e' => $e,
    //                         ]);
    //                 }
    //             }

    //             return redirect()->back()->with('success', 'Cập nhật kế hoạch thành công từ file Excel.');
    //         } else {
    //             return redirect()->back()->with('error', 'Dữ liệu trong file không hợp lệ.');
    //         }
    //     } catch (\Exception $e) {
    //         \Log::error('Excel import error: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý file: ' . $e->getMessage());
    //     }
    // }




}
