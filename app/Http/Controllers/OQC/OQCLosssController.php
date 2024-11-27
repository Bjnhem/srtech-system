<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use App\Models\OQC\Plan;
use Illuminate\Http\Request;

class OQCLosssController extends Controller
{
    /**
     * Lấy danh sách shift, line, model theo ngày
     */
    public function getPlanData(Request $request)
    {
        // Lấy ngày và các tham số khác từ request
        $date = $request->input('date');
        $shift = $request->input('shift', null);
        $line = $request->input('line', null);
        $model = $request->input('model', null);

        // Lọc theo ngày
        $query = Plan::where('date', $date);

        // Lọc theo shift, line, model nếu có
        if ($shift) {
            $query->where('shift', $shift);
        }

        if ($line) {
            $query->where('line', $line);
        }

        if ($model) {
            $query->where('model', $model);
        }

        // Lấy dữ liệu tương ứng
        $plans = $query->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($plans);
    }

    /**
     * Lấy danh sách các shift, line, model không trùng lặp
     */
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
        $lines = [];
        if (!empty($shift)) {
            $lines = Plan::where('date', $date)
                ->where('shift', $shift)
                ->distinct()->pluck('line');
        }

        // Lấy các model không trùng lặp nếu có line
        $models = [];
        if (!empty($line)) {
            $models = Plan::where('date', $date)
                ->where('shift', $shift)
                ->where('line', $line)
                ->distinct()->pluck('model');
        }

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'status' => '200',
            'shifts' => $shifts,
            'lines' => $lines,
            'models' => $models,
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
            return response()->json([
                'prod_qty' => $plan->$time, // A, B, C, D, E
            ]);
        } else {
            return response()->json(['prod_qty' => null]);
        }
    }
}
