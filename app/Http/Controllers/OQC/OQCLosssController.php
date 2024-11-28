<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use App\Models\OQC\ErrorList;
use App\Models\OQC\LineLoss;
use App\Models\OQC\Plan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Schema;



class OQCLosssController extends Controller
{

    //  Lấy danh sách các shift, line, model không trùng lặp

    public function getDropdownData(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');
        $line = $request->input('line');

        // Kiểm tra nếu không có ngày
        if (empty($date)) {
            return response()->json([
                'status' => '400',
                'messcess' => 'Chưa chọn ngày'
            ]);
        }
        $plansExist = Plan::where('date', $date)->exists(); // Kiểm tra xem có bất kỳ bản ghi nào với ngày này không
        if (!$plansExist) {
            return response()->json([
                'status' => '400',
                'messcess' => 'Ngày đã chọn không có plan - vui lòng input plan'
            ]);
        }
        // Lấy các shift không trùng lặp
        $shifts = Plan::where('date', $date)->distinct()->pluck('shift');

        // Lấy các line không trùng lặp nếu có shift
        $lines = Plan::where('date', $date)
            ->distinct()
            ->select('line', 'shift') // Chọn cả line và shift
            ->get();


        // Lấy các model không trùng lặp nếu có line
        $models = Plan::where('date', $date)
            ->get();

        $item_loss = ErrorList::all();
        $category = ErrorList::distinct()
            ->pluck('category');
        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'status' => '200',
            'shifts' => $shifts,
            'lines' => $lines,
            'models' => $models,
            'item_loss' => $item_loss,
            'category' => $category,
        ]);
    }
    /**
     * Lấy sản lượng theo khung giờ
     */
    public function getProdQty(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');
        $line = $request->input('line');
        $model = $request->input('model');
        $time = $request->input('time'); // A, B, C, D, E


        // Tìm bản ghi phù hợp
        $plan = Plan::where('date', $date)
            ->where('shift', $shift)
            ->where('line', $line)
            ->where('model', $model)
            ->first();



        // Kiểm tra và trả về sản lượng theo khung giờ
        if ($plan) {
            $plan_id = $plan->id;
            $NG_qty = LineLoss::where('plan_id', $plan_id)
                ->where('time_slot', $time)
                ->sum('NG_qty');

            return response()->json([
                'status' => 200,
                'prod_qty' => $plan->$time, // A, B, C, D, E
                'NG_qty' => $NG_qty, // A, B, C, D, E
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'messcess' => 'Không có plan cho khung giờ đã chọn'
            ]);
        }
    }

    public function showData_loss_detail(Request $request)
    {
        // Lấy thông tin từ request
        $date = $request->input('date');
        $shift = $request->input('shift');
        $line = $request->input('line');
        $time = ($request->input('time') === 'All') ? null : $request->input('time');

        // Khởi tạo truy vấn với join các bảng liên quan
        $query = LineLoss::query()
            ->select(
                'line_losses.time_slot',
                'line_losses.prod_qty',
                'line_losses.NG_qty',
                'line_losses.remark',
                'line_losses.Code_ID',
                'line_losses.id',
                'plans.date',
                'plans.shift',
                'plans.line',
                'errors_list.category',
                'errors_list.name',
            )
            ->orderBy('line_losses.id', 'desc')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id') // Join với bảng plans
            ->join('errors_list', 'line_losses.error_list_id', '=', 'errors_list.id'); // Join với bảng errors_list


        // Lọc dữ liệu dựa trên request
        if (!empty($date)) {
            $query->whereDate('plans.date', $date);
        }
        if (!empty($shift)) {
            $query->where('plans.shift', $shift);
        }
        if (!empty($line)) {
            $query->where('plans.line', $line);
        }
        if (!empty($time)) {
            $query->where('time_slot', $time);
        }

        // Tổng số bản ghi lọc được và tổng tất cả bản ghi
        $filteredRecords = $query->count();
        $totalRecords = LineLoss::count();

        // Phân trang dữ liệu
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $products = $query->skip($start)->take($length)->get();

        // Trả dữ liệu JSON cho DataTables
        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products
        ]);
    }

    public function data_loss_search(Request $request)
    {

        $id = $request->input('id');

        $loss_detail = LineLoss::find($id);
        if ($loss_detail) {
            return response()->json([
                'status' => 200,
                'data' => $loss_detail
            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }

        // Trả dữ liệu JSON cho DataTables

    }


    public function delete_data_row_table(Request $request)
    {
        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan" || $request->input('table') == "LineLoss") {
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

        if ($request->input('table') == "ErrorList" || $request->input('table') == "Plan" || $request->input('table') == "LineLoss") {
            $table = 'App\Models\OQC\\' . $request->input('table');
        } else {
            $table = 'App\Models\\' . $request->input('table');
        }
        $models = new $table;
        $tables = $models->getTable();
        $id = $request->input('id', null);

        $columns = Schema::getColumnListing($tables);
        $columns = array_diff($columns, ['id', 'table', 'created_at', 'updated_at', 'category', 'name']);
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
}
