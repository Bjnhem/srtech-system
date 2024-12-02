<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use App\Models\OQC\ErrorList;
use App\Models\OQC\LineLoss;
use App\Models\OQC\Plan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;





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


    public function calculateSummary()
    {
        // Xóa dữ liệu cũ trong bảng summary
        DB::table('line_losses_summary')->truncate();

        // Tổng hợp dữ liệu theo các mức thời gian
        $timeGroups = [
            'day' => DB::raw('DATE(plans.date) as date'), // Lấy ngày từ bảng plans
        ];

        // Tính Prod [ea]
        $prodData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id') // Join bảng plans với line_losses
            ->select(
                'plans.model', // Lấy model từ bảng plans
                DB::raw("'Prod [ea]' as item"),
                $timeGroups['day'],  // Nhóm theo ngày từ bảng plans
                DB::raw('SUM(DISTINCT plans.prod) as value') // Lấy tổng số lượng prod từ bảng plans, tránh trùng lặp
            )
            ->groupBy('plans.model', DB::raw('DATE(plans.date)')) // Nhóm theo model và ngày trong bảng plans
            ->get();
        // Tính Q'ty NG [ea]
        $ngData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id') // Join bảng plans với line_losses
            ->select(
                'plans.model', // Lấy model từ bảng plans
                DB::raw("'Q\'ty NG [ea]' as item"),
                $timeGroups['day'],  // Nhóm theo ngày từ bảng plans
                DB::raw('SUM(line_losses.NG_qty) as value') // Lấy tổng số lượng prod từ bảng plans, tránh trùng lặp
            )
            ->groupBy('plans.model', DB::raw('DATE(plans.date)')) // Nhóm theo model và ngày trong bảng plans
            ->get();

        // Tính Rate [%] (Rate = Q'ty NG / Prod * 100)
        $rateData = DB::table('line_losses')
            ->join('plans', 'line_losses.plan_id', '=', 'plans.id') // Join bảng plans với line_losses
            ->select(
                'plans.model',
                DB::raw("'Rate [%]' as item"),
                $timeGroups['day'],  // Nhóm theo ngày từ bảng plans
                DB::raw('CASE WHEN SUM(DISTINCT plans.prod) > 0 THEN ROUND((SUM(line_losses.NG_qty) / SUM(DISTINCT plans.prod)) * 100, 2) 
                ELSE 0 END as value')
            )
            ->groupBy('plans.model', DB::raw('DATE(plans.date)')) // Nhóm theo model và ngày trong bảng plans
            ->get();

        // Kết hợp tất cả dữ liệu và insert vào bảng summary
        $combinedData = collect([$prodData, $ngData, $rateData])->collapse();

        // Lặp qua dữ liệu và insert vào bảng tổng hợp
        foreach ($combinedData as $data) {
            DB::table('line_losses_summary')->insert([
                'model'     => $data->model,
                'item'      => $data->item,
                'year'      => date('Y', strtotime($data->date)), // Lấy năm từ cột date
                'month'     => date('m', strtotime($data->date)), // Lấy tháng từ cột date
                'week'      => date('W', strtotime($data->date)), // Lấy tuần từ cột date
                'date'      => $data->date,
                'value'     => $data->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }



    // public function showSummary()
    // {
    //     // Lấy dữ liệu từ bảng line_losses_summary
    //     $summaryData = DB::table('line_losses_summary')
    //         ->select('model', 'item', 'year', 'month', 'week', 'date', 'value')
    //         ->orderBy('date') // Sắp xếp theo ngày
    //         ->get();

    //     // Tính toán tổng hợp dữ liệu theo tháng, tuần, năm
    //     $groupedData = [];

    //     foreach ($summaryData as $row) {
    //         // Nhóm dữ liệu theo model và item
    //         if (!isset($groupedData[$row->model])) {
    //             $groupedData[$row->model] = [];
    //         }

    //         if (!isset($groupedData[$row->model][$row->item])) {
    //             $groupedData[$row->model][$row->item] = [
    //                 'year' => [],
    //                 'month' => [],
    //                 'week' => [],
    //                 'day' => [],
    //                 'prod' => 0,  // Tổng số Prod
    //                 'ng_qty' => 0, // Tổng số NG_qty
    //             ];
    //         }

    //         // Thêm dữ liệu cho từng ngày
    //         $groupedData[$row->model][$row->item]['day'][$row->date] = $row->value;

    //         // Tính tổng số liệu cho từng tuần
    //         $weekKey = $row->year . '-W' . str_pad($row->week, 2, '0', STR_PAD_LEFT);
    //         if (!isset($groupedData[$row->model][$row->item]['week'][$weekKey])) {
    //             $groupedData[$row->model][$row->item]['week'][$weekKey] = 0;
    //         }
    //         $groupedData[$row->model][$row->item]['week'][$weekKey] += $row->value;

    //         // Tính tổng số liệu cho từng tháng
    //         $monthKey = $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT);
    //         if (!isset($groupedData[$row->model][$row->item]['month'][$monthKey])) {
    //             $groupedData[$row->model][$row->item]['month'][$monthKey] = 0;
    //         }
    //         $groupedData[$row->model][$row->item]['month'][$monthKey] += $row->value;

    //         // Tính tổng số liệu cho từng năm
    //         $yearKey = $row->year;
    //         if (!isset($groupedData[$row->model][$row->item]['year'][$yearKey])) {
    //             $groupedData[$row->model][$row->item]['year'][$yearKey] = 0;
    //         }
    //         $groupedData[$row->model][$row->item]['year'][$yearKey] += $row->value;

    //         // Cộng dồn tổng số Prod và NG_qty
    //         if ($row->item == 'Prod [ea]') {
    //             $groupedData[$row->model][$row->item]['prod'] += $row->value;
    //         } elseif ($row->item == "Q'ty NG [ea]") {
    //             $groupedData[$row->model][$row->item]['ng_qty'] += $row->value;
    //         }
    //     }

    //     // Tính tỷ lệ Rate cho từng model, item theo các khoảng thời gian
    //     foreach ($groupedData as $model => $items) {
    //         foreach ($items as $item => $data) {
    //             foreach (['year', 'month', 'week', 'day'] as $timePeriod) {
    //                 // Tính tỷ lệ theo từng thời kỳ (năm, tháng, tuần, ngày)
    //                 foreach ($data[$timePeriod] as $key => $value) {
    //                     $prod = $data['prod'];
    //                     $ng_qty = $data['ng_qty'];
    //                     $rate = ($prod > 0) ? ($ng_qty / $prod) * 100 : 0;
    //                     $groupedData[$model][$item][$timePeriod][$key] = [
    //                         'value' => $value,
    //                         'rate' => $rate,  // Lưu tỷ lệ tính được
    //                     ];
    //                 }
    //             }
    //         }
    //     }

    //     // Truyền dữ liệu vào view
    //     return view('ilsung.OQC.pages.Overview', ['groupedData' => $groupedData]);

    // }

    public function showSummary()
    {
        // Lấy dữ liệu từ bảng line_losses_summary
        $summaryData = DB::table('line_losses_summary')
            ->select('model', 'item', 'year', 'month', 'week', 'date', 'value')
            ->orderBy('date') // Sắp xếp theo ngày
            ->get();

        // Tính toán tổng hợp dữ liệu theo tháng, tuần, năm
        $groupedData = [];
        $allModelData = [
            'prod' => 0,  // Tổng số Prod
            'ng_qty' => 0, // Tổng số NG_qty
        ];

        foreach ($summaryData as $row) {
            // Nhóm dữ liệu theo model và item
            if (!isset($groupedData[$row->model])) {
                $groupedData[$row->model] = [];
            }

            if (!isset($groupedData[$row->model][$row->item])) {
                $groupedData[$row->model][$row->item] = [
                    'year' => [],
                    'month' => [],
                    'week' => [],
                    'day' => [],
                    'prod' => 0,  // Tổng số Prod
                    'ng_qty' => 0, // Tổng số NG_qty
                    'rate' => 0, // Tổng số NG_qty
                ];
            }

            // Thêm dữ liệu cho từng ngày
            $groupedData[$row->model][$row->item]['day'][$row->date] = $row->value;

            // Tính tổng số liệu cho từng tuần
            $weekKey = $row->year . '-W' . str_pad($row->week, 2, '0', STR_PAD_LEFT);
            if (!isset($groupedData[$row->model][$row->item]['week'][$weekKey])) {
                $groupedData[$row->model][$row->item]['week'][$weekKey] = 0;
            }
            $groupedData[$row->model][$row->item]['week'][$weekKey] += $row->value;

            // Tính tổng số liệu cho từng tháng
            $monthKey = $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT);
            if (!isset($groupedData[$row->model][$row->item]['month'][$monthKey])) {
                $groupedData[$row->model][$row->item]['month'][$monthKey] = 0;
            }
            $groupedData[$row->model][$row->item]['month'][$monthKey] += $row->value;

            // Tính tổng số liệu cho từng năm
            $yearKey = $row->year;
            if (!isset($groupedData[$row->model][$row->item]['year'][$yearKey])) {
                $groupedData[$row->model][$row->item]['year'][$yearKey] = 0;
            }

            $groupedData[$row->model][$row->item]['year'][$yearKey] += $row->value;

            // Cộng dồn tổng số Prod và NG_qty
            if ($row->item == 'Prod [ea]') {
                $groupedData[$row->model][$row->item]['prod'] += $row->value;
                $allModelData['prod'] += $row->value; // Cộng dồn cho All model
            } elseif ($row->item == "Q'ty NG [ea]") {
                $groupedData[$row->model][$row->item]['ng_qty'] += $row->value;
                $allModelData['ng_qty'] += $row->value; // Cộng dồn cho All model
            }
        }

        // Tính tỷ lệ Rate cho từng model, item theo các khoảng thời gian
        foreach ($groupedData as $model => $items) {
            foreach ($items as $item => $data) {
                foreach (['year', 'month', 'week', 'day'] as $timePeriod) {
                    // Tính tỷ lệ theo từng thời kỳ (năm, tháng, tuần, ngày)
                    foreach ($data[$timePeriod] as $key => $value) {
                        $prod = $data['prod'];
                        $ng_qty = $data['ng_qty'];
                        $rate = ($prod > 0) ? ($ng_qty / $prod) * 100 : 0;
                        $groupedData[$model][$item][$timePeriod][$key] = [
                            'value' => $value,
                            'rate' => $rate,  // Lưu tỷ lệ tính được
                        ];
                    }
                }
            }
        }

        // Tính tỷ lệ cho All Model
        $allModelRate = ($allModelData['prod'] > 0) ? ($allModelData['ng_qty'] / $allModelData['prod']) * 100 : 0;

        // // Thêm dữ liệu "All model"
        // $groupedData['All model'] = [
        //     'Prod [ea]' => [
        //         'prod' => $allModelData['prod'],
        //         'ng_qty' => $allModelData['ng_qty'],
        //         'rate' => $allModelRate,

        //     ],
        //     "Q'ty NG [ea]" => [
        //         'prod' => $allModelData['prod'],
        //         'ng_qty' => $allModelData['ng_qty'],
        //         'rate' => $allModelRate,
        //     ],

        //     "Rate [%]" => [
        //         'prod' => $allModelData['prod'],
        //         'ng_qty' => $allModelData['ng_qty'],
        //         'rate' => $allModelRate,
        //     ],
        //     // Dữ liệu cho các mục khác như 'Rate Target', 'Rate', v.v.
        // ];

        // Truyền dữ liệu vào view
        return view('ilsung.OQC.pages.Overview', ['groupedData' => $groupedData]);
    }

    public function getData2()
    {
        // Lấy ngày hôm nay
        $today = Carbon::today();

        // Tạo tên cột động
        $headers = [
            'Model',
            'Item',
            $today->copy()->format('Y'),
            'M' . $today->copy()->subMonths(3)->format('m'),
            'M' . $today->copy()->subMonths(2)->format('m'),
            'M' . $today->copy()->subMonths(1)->format('m'),
            'W' . $today->copy()->subWeeks(3)->isoWeek(),
            'W' . $today->copy()->subWeeks(2)->isoWeek(),
            'W' . $today->copy()->subWeeks(1)->isoWeek(),
            $today->clone()->subDays(3)->format('d-M'),
            $today->clone()->subDays(2)->format('d-M'),
            $today->clone()->subDays(1)->format('d-M'),
        ];

        $khung_gio = [
            $today->copy()->format('Y'),
            'M' . $today->copy()->subMonths(3)->format('m'),
            'M' . $today->copy()->subMonths(2)->format('m'),
            'M' . $today->copy()->subMonths(1)->format('m'),
            'W' . $today->copy()->subWeeks(3)->isoWeek(),
            'W' . $today->copy()->subWeeks(2)->isoWeek(),
            'W' . $today->copy()->subWeeks(1)->isoWeek(),
            $today->clone()->subDays(3)->format('d-M'),
            $today->clone()->subDays(2)->format('d-M'),
            $today->clone()->subDays(1)->format('d-M'),
        ];


        $today = Carbon::today(); // Lấy ngày hôm nay

        // 3 mốc thời gian bạn muốn: 3 tháng, 3 tuần, và 3 ngày trước
        $startOfThreeMonthsAgo = $today->clone()->subMonths(3)->startOfMonth();
        $startOfThreeWeeksAgo = $today->clone()->subWeeks(3)->startOfWeek();
        $startOfThreeDaysAgo = $today->clone()->subDays(3)->startOfDay();

        // Truy vấn theo ngày (từ 3 ngày trước)
        $dataByDay = DB::table('line_losses_summary')
            ->select('model', 'item', 'date', DB::raw('SUM(value) as total_value'))
            ->where('date', '>=', $startOfThreeDaysAgo)
            ->groupBy('model', 'item', 'date')
            ->get();

        // Truy vấn theo tuần (từ 3 tuần trước)
        $dataByWeek = DB::table('line_losses_summary')
            ->select('model', 'item', 'year', 'week', DB::raw('SUM(value) as total_value'))
            ->where('year', '>=', $startOfThreeWeeksAgo->year)  // Lọc theo năm và tuần
            ->where('week', '>=', $startOfThreeWeeksAgo->weekOfYear)
            ->groupBy('model', 'item', 'year', 'week')
            ->get();

        // Truy vấn theo tháng (từ 3 tháng trước)
        $dataByMonth = DB::table('line_losses_summary')
            ->select('model', 'item', 'year', 'month', DB::raw('SUM(value) as total_value'))
            ->where('year', '>=', $startOfThreeMonthsAgo->year)  // Lọc theo năm và tháng
            ->where('month', '>=', $startOfThreeMonthsAgo->month)
            ->groupBy('model', 'item', 'year', 'month')
            ->get();


        function update_rate($data)
        {

            $prodValue = 0;
            $ngValue = 0;
            // Lặp qua dữ liệu của model và phân loại các giá trị
            foreach ($data as $item) {
                if ($item->item == 'Prod [ea]') {
                    $prodValue = $item->value; // Lưu giá trị sản phẩm
                } elseif ($item->item == "Q'ty NG [ea]") {
                    $ngValue = $item->value; // Lưu giá trị sản phẩm lỗi
                }
            }

            // Tính toán tỷ lệ Rate [%]
            if ($prodValue != 0) {
                $rate = ($ngValue / $prodValue) * 100; // Tính tỷ lệ phần trăm
            } else {
                $rate = 0; // Nếu không có sản phẩm, tỷ lệ là 0
            }

            // Lưu tỷ lệ vào cơ sở dữ liệu
            DB::table('line_losses_summary')
                ->where('model', 'P615')
                ->where('year', 2024)
                ->where('month', 11)
                ->where('week', 48)
                ->where('item', 'Rate [%]')
                ->update(['value' => $rate]);
        }

        $summaryData = DB::table('line_losses_summary')
            ->select('model', 'item', 'year', 'month', 'week', 'date', 'value')
            ->orderBy('date') // Sắp xếp theo ngày
            ->get();

        $groupedData = [];
        $allModelsData = [
            'Model' => 'All Models', // Tên model tổng hợp
            'Item' => 'Total',
            $today->copy()->format('Y') => 0,
            'M' . $today->copy()->subMonths(3)->format('m') => 0,
            'M' . $today->copy()->subMonths(2)->format('m') => 0,
            'M' . $today->copy()->subMonths(1)->format('m') => 0,
            'W' . $today->copy()->subWeeks(3)->isoWeek() => 0,
            'W' . $today->copy()->subWeeks(2)->isoWeek() => 0,
            'W' . $today->copy()->subWeeks(1)->isoWeek() => 0,
            $today->clone()->subDays(3)->format('d-M') => 0,
            $today->clone()->subDays(2)->format('d-M') => 0,
            $today->clone()->subDays(1)->format('d-M') => 0,
        ];


        foreach ($summaryData as $row) {
            // Nhóm dữ liệu theo model và item
            if (!isset($groupedData[$row->model])) {
                $groupedData[$row->model] = [];
            }

            if (!isset($groupedData[$row->model][$row->item])) {
                // Khởi tạo dữ liệu cho từng item, model
                $groupedData[$row->model][$row->item] = [
                    $today->copy()->format('Y') => 0,
                    'M' . $today->copy()->subMonths(3)->format('m') => 0,
                    'M' . $today->copy()->subMonths(2)->format('m') => 0,
                    'M' . $today->copy()->subMonths(1)->format('m') => 0,
                    'W' . $today->copy()->subWeeks(3)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(2)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(1)->isoWeek() => 0,
                    $today->clone()->subDays(3)->format('d-M') => 0,
                    $today->clone()->subDays(2)->format('d-M') => 0,
                    $today->clone()->subDays(1)->format('d-M') => 0,

                ];
            }

            // Lấy ngày hôm nay
            $today = \Carbon\Carbon::today();

            // Kiểm tra và cộng dồn vào các khoảng thời gian tương ứng
            if ($row->month == $today->copy()->subMonths(3)->month) {
                $groupedData[$row->model][$row->item]['M' . $today->copy()->subMonths(3)->format('m')] += $row->value;
                $allModelsData['M' . $today->copy()->subMonths(3)->format('m')] += $row->value; // Cộng vào All Models
            }
            if ($row->month == $today->copy()->subMonths(2)->month) {
                $groupedData[$row->model][$row->item]['M' . $today->copy()->subMonths(2)->format('m')] += $row->value;
            }
            if ($row->month == $today->copy()->subMonths(1)->month) {
                $groupedData[$row->model][$row->item]['M' . $today->copy()->subMonths(1)->format('m')] += $row->value;
            }

            if ($row->week == $today->copy()->subWeeks(3)->isoWeek()) {
                $groupedData[$row->model][$row->item]['W' . $today->copy()->subWeeks(3)->isoWeek()] += $row->value;
            }
            if ($row->week == $today->copy()->subWeeks(2)->isoWeek()) {
                $groupedData[$row->model][$row->item]['W' . $today->copy()->subWeeks(2)->isoWeek()] += $row->value;
            }
            if ($row->week == $today->copy()->subWeeks(1)->isoWeek()) {
                $groupedData[$row->model][$row->item]['W' . $today->copy()->subWeeks(1)->isoWeek()] += $row->value;
            }

            if ($row->date == $today->copy()->subDays(3)->format('Y-m-d')) {
                $groupedData[$row->model][$row->item][$today->clone()->subDays(3)->format('d-M')] += $row->value;
            }
            if ($row->date == $today->copy()->subDays(2)->format('Y-m-d')) {
                $groupedData[$row->model][$row->item][$today->clone()->subDays(2)->format('d-M')] += $row->value;
            }
            if ($row->date == $today->copy()->subDays(1)->format('Y-m-d')) {
                $groupedData[$row->model][$row->item][$today->clone()->subDays(1)->format('d-M')] += $row->value;
            }

            // Cộng tổng cho năm
            if ($row->year == $today->copy()->year) {
                $groupedData[$row->model][$row->item][$today->copy()->format('Y')] += $row->value;
            }
        }

        foreach ($groupedData as $model => $values) {
            // Lấy số liệu NG và Prod cho mỗi model
            $ng = $values["Q'ty NG [ea]"];
            $prod = $values["Prod [ea]"];

            // Tạo mảng lưu tỷ lệ Rate
            $rate = [];

            // Lặp qua từng thời điểm và tính tỷ lệ Rate
            foreach ($ng as $period => $ngValue) {
                // Kiểm tra nếu có sản phẩm (prod[$period]) và prod[$period] không phải là 0
                if (isset($prod[$period]) && $prod[$period] != 0) {
                    $rate[$period] = round(($ngValue / $prod[$period]) * 100, 2);
                } else {
                    $rate[$period] = '-'; // Nếu không có sản phẩm hoặc sản phẩm = 0, gán tỷ lệ là 0
                }
            }

            // Cập nhật tỷ lệ Rate vào dữ liệu
            $groupedData[$model]["Rate [%]"] = $rate;
        }

        // foreach ($groupedData as $model => $items) {
        //     foreach ($items as $item => $data) {

        //         foreach ($khung_gio as $timePeriod) {
        //             // Tính tỷ lệ theo từng thời kỳ (năm, tháng, tuần, ngày)
        //             foreach ($data[$timePeriod] as $key => $value) {
        //                 $prod = $data['prod'];
        //                 $ng_qty = $data['ng_qty'];
        //                 $rate = ($prod > 0) ? ($ng_qty / $prod) * 100 : 0;
        //                 $groupedData[$model][$item][$timePeriod][$key] = [
        //                     'value' => $value,
        //                     'rate' => $rate,  // Lưu tỷ lệ tính được
        //                 ];
        //             }
        //         }
        //     }
        // }


        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'headers' => $headers,
            'data' => $groupedData,
        ]);
    }

    public function getData()
    {
        // Lấy ngày hôm nay
        $today = Carbon::today();

        // Tạo tên cột động
        $headers = [
            'Model',
            'Item',
            $today->copy()->format('Y'),
            'M' . $today->copy()->subMonths(3)->format('m'),
            'M' . $today->copy()->subMonths(2)->format('m'),
            'M' . $today->copy()->subMonths(1)->format('m'),
            'W' . $today->copy()->subWeeks(3)->isoWeek(),
            'W' . $today->copy()->subWeeks(2)->isoWeek(),
            'W' . $today->copy()->subWeeks(1)->isoWeek(),
            $today->clone()->subDays(3)->format('d-M'),
            $today->clone()->subDays(2)->format('d-M'),
            $today->clone()->subDays(1)->format('d-M'),
        ];


        $summaryData = DB::table('line_losses_summary')
            ->select('model', 'item', 'year', 'month', 'week', 'date', 'value')
            ->orderBy('date') // Sắp xếp theo ngày
            ->get();

        $groupedData = [];
        $allModelsData = [];

        // $allModelsData = [
        //     'Model' => 'All Models', // Tên model tổng hợp
        //     'Item' => 'Total',
        //     $today->copy()->format('Y') => 0,
        //     'M' . $today->copy()->subMonths(3)->format('m') => 0,
        //     'M' . $today->copy()->subMonths(2)->format('m') => 0,
        //     'M' . $today->copy()->subMonths(1)->format('m') => 0,
        //     'W' . $today->copy()->subWeeks(3)->isoWeek() => 0,
        //     'W' . $today->copy()->subWeeks(2)->isoWeek() => 0,
        //     'W' . $today->copy()->subWeeks(1)->isoWeek() => 0,
        //     $today->clone()->subDays(3)->format('d-M') => 0,
        //     $today->clone()->subDays(2)->format('d-M') => 0,
        //     $today->clone()->subDays(1)->format('d-M') => 0,
        // ];


        foreach ($summaryData as $row) {

            // Nhóm dữ liệu theo model và item
            if (!isset($groupedData[$row->model])) {
                $groupedData[$row->model] = [];
            }


            if (!isset($groupedData[$row->model][$row->item])) {
                // Khởi tạo dữ liệu cho từng item, model
                $groupedData[$row->model][$row->item] = [
                    $today->copy()->format('Y') => 0,
                    'M' . $today->copy()->subMonths(3)->format('m') => 0,
                    'M' . $today->copy()->subMonths(2)->format('m') => 0,
                    'M' . $today->copy()->subMonths(1)->format('m') => 0,
                    'W' . $today->copy()->subWeeks(3)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(2)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(1)->isoWeek() => 0,
                    $today->clone()->subDays(3)->format('d-M') => 0,
                    $today->clone()->subDays(2)->format('d-M') => 0,
                    $today->clone()->subDays(1)->format('d-M') => 0,
                ];

                $allModelsData['All Models'][$row->item] = [
                    $today->copy()->format('Y') => 0,
                    'M' . $today->copy()->subMonths(3)->format('m') => 0,
                    'M' . $today->copy()->subMonths(2)->format('m') => 0,
                    'M' . $today->copy()->subMonths(1)->format('m') => 0,
                    'W' . $today->copy()->subWeeks(3)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(2)->isoWeek() => 0,
                    'W' . $today->copy()->subWeeks(1)->isoWeek() => 0,
                    $today->clone()->subDays(3)->format('d-M') => 0,
                    $today->clone()->subDays(2)->format('d-M') => 0,
                    $today->clone()->subDays(1)->format('d-M') => 0,
                ];
            }


            // Các khoảng thời gian cần kiểm tra (tháng, tuần, ngày, năm)
            $timePeriods = [
                'months' => [3, 2, 1], // Tháng 3, 2, 1
                'weeks' => [3, 2, 1],  // Tuần 3, 2, 1
                'days' => [3, 2, 1],   // Ngày 3, 2, 1
            ];

            // Lặp qua các khoảng thời gian
            foreach ($timePeriods as $period => $values) {
                foreach ($values as $value) {
                    switch ($period) {
                        case 'months':
                            $date = $today->copy()->subMonths($value);
                            $periodKey = 'M' . $date->format('m');
                            if ($row->month == $date->month) {
                                $groupedData[$row->model][$row->item][$periodKey] += $row->value;
                                $allModelsData['All Models'][$row->item][$periodKey] += $row->value;
                            }
                            break;

                        case 'weeks':
                            $date = $today->copy()->subWeeks($value);
                            $periodKey = 'W' . $date->isoWeek();
                            if ($row->week == $date->isoWeek()) {
                                $groupedData[$row->model][$row->item][$periodKey] += $row->value;
                                $allModelsData['All Models'][$row->item][$periodKey] += $row->value;
                            }
                            break;

                        case 'days':
                            $date = $today->copy()->subDays($value);
                            $periodKey = $date->format('d-M');
                            if ($row->date == $date->format('Y-m-d')) {
                                $groupedData[$row->model][$row->item][$periodKey] += $row->value;
                                $allModelsData['All Models'][$row->item][$periodKey] += $row->value;
                            }
                            break;
                    }
                }
            }

            // Cộng tổng cho năm
            if ($row->year == $today->copy()->year) {
                $groupedData[$row->model][$row->item][$today->copy()->format('Y')] += $row->value;
                $allModelsData['All Models'][$row->item][$today->copy()->format('Y')] += $row->value;
            }
        }

        $data= array_merge([$allModelsData], $groupedData);
        

        foreach ($groupedData as $model => $values) {
            // Lấy số liệu NG và Prod cho mỗi model
            $ng = $values["Q'ty NG [ea]"];
            $prod = $values["Prod [ea]"];

            // Tạo mảng lưu tỷ lệ Rate
            $rate = [];

            // Lặp qua từng thời điểm và tính tỷ lệ Rate
            foreach ($ng as $period => $ngValue) {
                // Kiểm tra nếu có sản phẩm (prod[$period]) và prod[$period] không phải là 0
                if (isset($prod[$period]) && $prod[$period] != 0) {
                    $rate[$period] = round(($ngValue / $prod[$period]) * 100, 2);
                } else {
                    $rate[$period] = '-'; // Nếu không có sản phẩm hoặc sản phẩm = 0, gán tỷ lệ là 0
                }
            }
            // Cập nhật tỷ lệ Rate vào dữ liệu
            $groupedData[$model]["Rate [%]"] = $rate;
        }
        // Tính tỷ lệ Rate cho All Models
        // $allModelsNG = $allModelsData["Q'ty NG [ea]"];
        // $allModelsProd = $allModelsData["Prod [ea]"];
        // $allModelsRate = [];

        // foreach ($allModelsNG as $period => $ngValue) {
        //     if (isset($allModelsProd[$period]) && $allModelsProd[$period] != 0) {
        //         $allModelsRate[$period] = round(($ngValue / $allModelsProd[$period]) * 100, 2);
        //     } else {
        //         $allModelsRate[$period] = '-'; // Nếu không có sản phẩm hoặc sản phẩm = 0, gán tỷ lệ là 0
        //     }
        // }

        // // Cập nhật tỷ lệ Rate cho All Models
        // $allModelsData["Rate [%]"] = $allModelsRate;

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'headers' => $headers,
            'data' => $groupedData,
            'data2' => $allModelsData,
        ]);
    }
}
