<?php

namespace App\Http\Controllers\WareHouse;

use App\Exports\ErrorExport;
use App\Http\Controllers\Controller;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\Product_warehouse;
use App\Models\WareHouse\StockMovement;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;




class WarehouseController extends Controller
{



    public function getPendingUsers()
    {
        // Truy vấn danh sách username có trạng thái pending
        $pendingUsers = DB::table('users')
            ->where('status', 'pending')
            ->select('username', 'updated_at')
            ->get();

        $count = $pendingUsers->count(); // Đếm số lượng thông báo

        return response()->json([
            'notifications' => $pendingUsers,
            'count' => $count,
        ]);
    }
    // controller view nhập xuất

    // show data master product search
    function get_search(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $action = $request->input('action');
        $pageSize = $request->input('pageSize', 10);
        $offset = ($page - 1) * $pageSize;

        // Truy vấn với offset và giới hạn

        if ($action == 'Import') {
            $products = DB::table('products')
                ->where('ID_SP', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->offset($offset)
                ->limit($pageSize)
                ->get();

            // Tổng số sản phẩm
            $totalCount = DB::table('products')
                ->where('ID_SP', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->count();
        } else {

            $products = DB::table('stock_view')
                ->join('products', 'stock_view.product_id', '=', 'products.id')
                ->select(
                    'stock_view.product_id as id',
                    DB::raw('MAX(products.name) as name'), // Lấy tên sản phẩm
                    DB::raw('MAX(products.ID_SP) as ID_SP'), // Lấy mã sản phẩm
                    DB::raw('MAX(products.image) as Image') // Lấy ảnh sản phẩm
                )
                ->where('products.ID_SP', 'like', "%{$search}%")
                ->orWhere('products.name', 'like', "%{$search}%")
                ->groupBy('stock_view.product_id') // Nhóm theo product_id
                ->orderBy('product_id', 'asc')
                ->offset($offset)
                ->limit($pageSize)
                ->get();



            // Tổng số sản phẩm
            $totalCount = DB::table('stock_view')
                ->join('products', 'stock_view.product_id', '=', 'products.id')
                ->select(
                    'stock_view.product_id',
                    DB::raw('MAX(products.name) as name'), // Lấy tên sản phẩm
                    DB::raw('MAX(products.ID_SP) as ID_SP'), // Lấy mã sản phẩm
                    DB::raw('MAX(products.image) as Image') // Lấy ảnh sản phẩm
                )
                ->where('products.ID_SP', 'like', "%{$search}%")
                ->orWhere('products.name', 'like', "%{$search}%")
                ->groupBy('stock_view.product_id') // Nhóm theo product_id
                ->get()
                ->count();
        }

        return response()->json([
            'products' => $products,
            'hasMore' => ($page * $pageSize) < $totalCount
        ]);
    }

    // show data master warehouse search
    function get_warehouse(Request $request)
    {
        $search = $request->input('search');
        $action = $request->input('action');
        $product_id = $request->input('product_id', null);
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $offset = ($page - 1) * $pageSize;

        $query_warehouse_1 = Warehouse::query();
        $query_warehouse_2 = Warehouse::query();
        $query_warehouse_1_count = Warehouse::query();
        $query_warehouse_2_count = Warehouse::query();
        $join_stock_view = DB::table('stock_view')
            ->join('warehouses', 'stock_view.warehouse_id', '=', 'warehouses.id')
            ->select('stock_view.*', 'warehouses.name', 'warehouses.id');

        // Tìm kiếm với tên kho (search) nếu có
        if ($search) {
            $query_warehouse_1->where('name', 'like', "%{$search}%");
            $query_warehouse_2->where('name', 'like', "%{$search}%");
            $query_warehouse_1_count->where('name', 'like', "%{$search}%");
            $query_warehouse_2_count->where('name', 'like', "%{$search}%");
            $join_stock_view->where('warehouses.name', 'like', "%{$search}%");
        }

        // Xử lý theo action
        switch ($action) {
            case 'Import':
                $warehouse_1 = $query_warehouse_1->where('status', 'OUT')->offset($offset)->limit($pageSize)->get();
                $warehouse_2 = $query_warehouse_2->where('status', 'IN')->offset($offset)->limit($pageSize)->get();

                $totalCount1 = $query_warehouse_1_count->where('status', 'OUT')->count();
                $totalCount2 =  $query_warehouse_2_count->where('status', 'IN')->count();
                break;

            case 'Export':
                $warehouse_1 = $join_stock_view->where('product_id', 'like', "%{$product_id}%")
                    ->offset($offset)->limit($pageSize)->get();
                $warehouse_2 = $query_warehouse_2->where('status', 'OUT')->offset($offset)->limit($pageSize)->get();

                $totalCount1 = $join_stock_view->where('product_id', 'like', "%{$product_id}%")->count();
                $totalCount2 =  $query_warehouse_2_count->where('status', 'OUT')->count();
                break;

            case 'Transfer':
                $warehouse_1 = $join_stock_view->where('product_id', 'like', "%{$product_id}%")
                    ->offset($offset)->limit($pageSize)->get();
                $warehouse_2 =  $query_warehouse_2_count->where('status', 'IN')->offset($offset)->limit($pageSize)->get();

                $totalCount1 = $join_stock_view->where('product_id', 'like', "%{$product_id}%")->count();
                $totalCount2 = $query_warehouse_2_count->where('status', 'IN')->count();
                break;

            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }

        return response()->json([
            'warehouse_1' => $warehouse_1,
            'warehouse_2' => $warehouse_2,
            'hasMore_1' => ($page * $pageSize) < $totalCount1,
            'hasMore_2' => ($page * $pageSize) < $totalCount2,
            'count' => $totalCount2,
        ]);
    }

    // show data master warehouse search
    function get_status(Request $request)
    {
        $search = $request->input('search');
        $warehouse_id = $request->input('warehouse_id', null);
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $offset = ($page - 1) * $pageSize;


        $join_stock_view = DB::table('stock_view')
            ->join('warehouses', 'stock_view.warehouse_id', '=', 'warehouses.id')
            ->select('stock_view.*', 'warehouses.name', 'warehouses.id');

        // Tìm kiếm với tên kho (search) nếu có
        if ($search) {
            $join_stock_view->where('warehouses.name', 'like', "%{$search}%");
        }

        $warehouse_1 = $join_stock_view->where('warehouse_id', 'like', "%{$warehouse_id}%")
            ->offset($offset)->limit($pageSize)->get();

        $totalCount1 = $join_stock_view->where('warehouse_id', 'like', "%{$warehouse_id}%")->count();

        return response()->json([
            'status' => $warehouse_1,
            'hasMore_1' => ($page * $pageSize) < $totalCount1,

        ]);
    }


    //  save data transfer history
    public function history_transfer(Request $request)
    {

        $request->validate([
            'products' => 'required|array|min:1', // Mảng sản phẩm phải có ít nhất một phần tử
            'products.*.target_warehouse_id' => 'required', // Kiểm tra tồn tại kho chuyển (From)
            'products.*.warehouse_id' => 'required|exists:warehouses,id', // Kiểm tra tồn tại kho nhận (To)
            'products.*.quantity' => 'required|integer|min:1', // Kiểm tra số lượng nhập kho phải là số nguyên và >= 1
            'products.*.action' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                // Lưu lại sự kiện nhập kho cho mỗi sản phẩm
                $target_warehouse = Warehouse::find($product['target_warehouse_id'])->name;
                $action = $product['action'];
                if ($action == 'Transfer') {
                    $target_warehouse_1 = Warehouse::find($product['warehouse_id'])->name;

                    StockMovement::create([
                        'product_id' => $product['product_id'],  // ID sản phẩm
                        'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                        'type' =>  $action, // Loại sự kiện nhập kho
                        'quantity' => $product['quantity'],
                        'quantity_sumary' => '-' . $product['quantity'],  // Số lượng nhập
                        'Remark' => 'Chuyển đi ' . $target_warehouse, // Số lượng nhập
                        'target_warehouse_id' => null, // Kho nhận (To)
                        'user' => Auth::user()->username, // Người chuyển
                    ]);

                    StockMovement::create([
                        'product_id' => $product['product_id'],  // ID sản phẩm
                        'warehouse_id' => $product['target_warehouse_id'], // Kho chuyển (From)
                        'type' =>  $action, // Loại sự kiện nhập kho
                        'quantity' => $product['quantity'],
                        'quantity_sumary' => $product['quantity'],  // Số lượng nhập
                        'Remark' => 'Nhận từ ' . $target_warehouse_1, // Số lượng nhập
                        'target_warehouse_id' => null, // Kho nhận (To)
                        'user' => Auth::user()->username, // Người chuyển

                    ]);
                } else {
                    if ($action == 'Import') {
                        $remark = 'Nhập từ ' . $target_warehouse;
                        $quantity = $product['quantity'];
                    }

                    if ($action == 'Export') {
                        $remark = 'Chuyển đi ' . $target_warehouse;
                        $quantity = '-' . $product['quantity'];
                    }
                    $target_warehouse_id = null;
                    StockMovement::create([
                        'product_id' => $product['product_id'],  // ID sản phẩm
                        'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                        'type' =>  $action, // Loại sự kiện nhập kho
                        'quantity' => $product['quantity'], // Số lượng nhập
                        'quantity_sumary' => $quantity, // Số lượng nhập
                        'Remark' => $remark, // Số lượng nhập
                        'target_warehouse_id' => $target_warehouse_id, // Kho nhận (To)
                        'user' => Auth::user()->username, // Người chuyển

                    ]);
                }
            }
        });

        return response()->json([
            'success' => 'THÀNH CÔNG!',
            'status' => 200
        ]);
    }

    // show data table history
    public function getHistorydata(Request $request)
    {

        // Lấy lịch sử nhập/xuất của sản phẩm
        $history = DB::table('transfer_history')
            ->join('products', 'transfer_history.product_id', '=', 'products.id')
            ->Join('warehouses', 'transfer_history.warehouse_id', '=', 'warehouses.id')
            ->select(
                'transfer_history.*',
                'products.ID_SP',
                'products.name as product_name',
                'warehouses.name as warehouse_name',
            )
            ->orderBy('transfer_history.created_at', 'desc')
            ->get();
        $response = [
            'history' => $history,
        ];

        return response()->json($response);
    }


    public function uploadAndLogHistory(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $errors = [];
        $historyData = []; // Data to log history
        $action = $request->input('action', 'Import'); // Assume 'Import' by default if not provided

        try {
            $data = Excel::toArray(new ProductImport, $request->file('excel_file'));

            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    if ($index == 0) {
                        continue; // Skip header row
                    }

                    // Extract fields
                    $name = $row[1] ?? null;
                    $type = $row[0] ?? null;
                    $ID_SP = $row[3] ?? null;
                    $quantity = $row[8] ?? 0; // Assuming the quantity is in the 9th column
                    $warehouseId = $row[10] ?? null; // Assuming warehouse ID is in the 11th column

                    // Validate data
                    if (empty($name) || empty($type) || empty($quantity) || empty($warehouseId)) {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Missing required fields (name, type, quantity, warehouse)',
                            'data' => $row,
                        ];
                        continue;
                    }

                    if ($quantity <= 0) {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Quantity must be greater than 0',
                            'data' => $row,
                        ];
                        continue;
                    }

                    // Check if the product exists
                    $product = DB::table('products')->where('ID_SP', $ID_SP)->first();

                    if ($product) {
                        // Prepare data for history logging
                        $historyData[] = [
                            'product_id' => $product->id,
                            'warehouse_id' => $warehouseId,
                            'type' => $action,
                            'quantity' => $quantity,
                            'quantity_sumary' => $action == 'Export' ? -$quantity : $quantity,
                            'Remark' => $action == 'Export' ? "Exported to Warehouse {$warehouseId}" : "Imported to Warehouse {$warehouseId}",
                            'user' => Auth::user()->username,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    } else {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Product does not exist',
                            'data' => $row,
                        ];
                    }
                }

                // Log valid history data
                if (!empty($historyData)) {
                    DB::table('stock_movements')->insert($historyData);
                }

                // Return errors as Excel file if any
                if (!empty($errors)) {
                    return Excel::download(new ErrorExport($errors), 'errors.xlsx');
                }

                return redirect()->back()->with('success', 'Data uploaded and history logged successfully.');
            }

            return redirect()->back()->with('error', 'The Excel file does not contain valid data.');
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
      


    public function updateFromExcel_product(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $errors = [];
        try {
            $data = Excel::toArray(new ProductImport, $request->file('excel_file'));

            if (is_array($data) && count($data) > 0) {
                foreach ($data[0] as $index => $row) {
                    if ($index == 0) continue; // Skip header

                    $name = $row[1] ?? null;
                    $type = $row[0] ?? null;
                    $ID_SP = $row[3] ?? null;

                    if (empty($name) || empty($type)) {
                        $errors[] = [
                            'row' => $index + 1,
                            'error' => 'Missing required fields (name or SKU)',
                            'data' => $row,
                        ];
                        continue;
                    }

                    $existingProduct = DB::table('products')->where('ID_SP', $ID_SP)->first();

                    if ($existingProduct) {
                        DB::table('products')->where('ID_SP', $ID_SP)->update([
                            'Type'        => $row[0] ?? null,
                            'name'        => $row[1] ?? null,
                            'Code_Purchase' => $row[2] ?? null,
                            'ID_SP' => $ID_SP ?? null,
                            'Part_ID'       => $row[4] ?? null,
                            'Model'       => $row[5] ?? null,
                            'vendor'      => $row[6] ?? null,
                            'version'     => $row[7] ?? null,
                            'stock_limit' => $row[8] ?? null,
                            'Image'       => $row[9] ?? null,
                            'updated_at' => now(),
                        ]);
                    } else {
                        $ID_SP = $this->created_ID_SP($type);
                        DB::table('products')->insert([
                            'Type'        => $row[0] ?? null,
                            'name'        => $row[1] ?? null,
                            'Code_Purchase' => $row[2] ?? null,
                            'ID_SP' =>   $ID_SP,
                            'Part_ID'       => $row[4] ?? null,
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

                if (!empty($errors)) {
                    return Excel::download(new ErrorExport($errors), 'errors.xlsx');
                }

                return redirect()->back()->with('success', 'Data updated successfully.');
            }

            return redirect()->back()->with('error', 'Invalid Excel file.');
        } catch (\Exception $e) {
            \Log::error('Excel import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function saveHistory(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.target_warehouse_id' => 'required',
            'products.*.warehouse_id' => 'required|exists:warehouses,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.action' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                $target_warehouse = Warehouse::find($product['target_warehouse_id'])->name;
                $action = $product['action'];

                if ($action == 'Transfer') {
                    $target_warehouse_1 = Warehouse::find($product['warehouse_id'])->name;

                    StockMovement::create([
                        'product_id' => $product['product_id'],
                        'warehouse_id' => $product['warehouse_id'],
                        'type' =>  $action,
                        'quantity' => $product['quantity'],
                        'quantity_sumary' => '-' . $product['quantity'],
                        'Remark' => 'Transferred to ' . $target_warehouse,
                        'target_warehouse_id' => null,
                        'user' => Auth::user()->username,
                    ]);

                    StockMovement::create([
                        'product_id' => $product['product_id'],
                        'warehouse_id' => $product['target_warehouse_id'],
                        'type' =>  $action,
                        'quantity' => $product['quantity'],
                        'quantity_sumary' => $product['quantity'],
                        'Remark' => 'Received from ' . $target_warehouse_1,
                        'target_warehouse_id' => null,
                        'user' => Auth::user()->username,
                    ]);
                } else {
                    $remark = $action == 'Import' ? 'Imported from ' . $target_warehouse : 'Exported to ' . $target_warehouse;
                    $quantity = $action == 'Import' ? $product['quantity'] : '-' . $product['quantity'];

                    StockMovement::create([
                        'product_id' => $product['product_id'],
                        'warehouse_id' => $product['warehouse_id'],
                        'type' =>  $action,
                        'quantity' => $product['quantity'],
                        'quantity_sumary' => $quantity,
                        'Remark' => $remark,
                        'target_warehouse_id' => null,
                        'user' => Auth::user()->username,
                    ]);
                }
            }
        });

        return response()->json([
            'success' => 'SUCCESS!',
            'status' => 200
        ]);
    }



    // controller view tồn kho


    // show data master warehouse search
    function get_warehouse_stock(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $offset = ($page - 1) * $pageSize;
        $product_id = $request->input('product_id', null);

        $join_stock_view = DB::table('stock_view')
            ->join('warehouses', 'stock_view.warehouse_id', '=', 'warehouses.id')
            ->select('stock_view.*', 'warehouses.name', 'warehouses.id', 'warehouses.location');

        if ($request->has('type') && $request->type != 'All') {
            $join_stock_view->where('stock_view.type', $request->type);
        }

        if ($request->has('warehouse_location') && $request->warehouse_location != 'All') {
            $join_stock_view->where('warehouses.location', $request->warehouse_location);
        }
        if ($request->has('product_id') && $request->product_id) {
            $join_stock_view->where('product_id', 'like', "%{$product_id}%"); // Lọc theo product_id
        }

        $warehouse_1 = $join_stock_view
            ->offset($offset)
            ->limit($pageSize)
            ->orderBy('warehouse_id', 'asc')
            ->get();
        $totalCount1 = $join_stock_view->count();

        return response()->json([
            'warehouse_1' => $warehouse_1,
            'hasMore_1' => ($page * $pageSize) < $totalCount1,
        ]);
    }

    public function getStock_product(Request $request)
    {
        // Lấy danh sách các sản phẩm và loại sản phẩm (tự động lọc theo stock > 0)
        $products = DB::table('stock_view')
            ->join('products', 'stock_view.product_id', '=', 'products.id') // Kết nối với bảng products để lấy tên sản phẩm
            ->join('warehouses', 'stock_view.warehouse_id', '=', 'warehouses.id')
            ->orderBy('stock_view.product_id', 'asc')
            ->select(
                'stock_view.product_id', // Đảm bảo có product_id trong select
                'warehouses.location', // Đảm bảo có product_id trong select
                // DB::raw('GROUP_CONCAT(warehouses.name, " - ", stock_view.stock_quantity ORDER BY warehouses.name ASC SEPARATOR ", ") as warehouse_name'), // Kết hợp kho và số lượng
                DB::raw('SUM(stock_view.stock_quantity) as stock_quantity'), // Tính tổng số lượng
                'products.name as product_name',
                'products.ID_SP as ID_SP',
                'products.Image as Image',
                'warehouses.name as warehouse_name'
            )
            ->groupBy('stock_view.product_id', 'products.name', 'products.ID_SP', 'products.Image', 'warehouses.name', 'warehouses.location') // Nhóm theo các trường này
            ->havingRaw('SUM(stock_view.stock_quantity) >= 0'); // Điều kiện lọc stock > 0


        // Lọc theo type (loại sản phẩm)
        if ($request->has('type') && $request->type != 'All') {
            $products->where('stock_view.type', $request->type);
        }

        if ($request->has('warehouse_location')  && $request->warehouse_location != 'All') {
            $products->where('warehouses.location', $request->warehouse_location); // Lọc theo product_id
        }


        if ($request->has('warehouse_id') && $request->warehouse_id) {
            $products->where('stock_view.warehouse_id', $request->warehouse_id); // Lọc theo product_id
        }

        // Lọc theo product_id (ID sản phẩm)
        if ($request->has('product_id') && $request->product_id) {
            $products->where('stock_view.product_id', $request->product_id); // Lọc theo product_id
        }

        // Lấy kết quả stock
        $products = $products->get();

        // Trả về kết quả và các trường lọc
        return response()->json([
            'products' => $products,
        ]);
    }



    // controller history
    public function History(Request $request)
    {
        // Lấy lịch sử nhập/xuất của sản phẩm
        $history = DB::table('transfer_history')
            ->join('products', 'transfer_history.product_id', '=', 'products.id')
            ->join('warehouses', 'transfer_history.warehouse_id', '=', 'warehouses.id')
            ->select(
                'transfer_history.*',
                'products.ID_SP',
                'products.Type as product_type',
                'products.name as product_name',
                'warehouses.name as warehouse_name',
                'warehouses.location as warehouse_status',
            )
            ->orderBy('transfer_history.created_at', 'desc');

        // Lọc theo type (loại sản phẩm)
        if ($request->has('type') && $request->type != 'All') {
            $history->where('products.Type', $request->type);
        }

        // Lọc theo tình trạng sản phẩm
        if ($request->has('status') && $request->status != 'All') {
            $history->where('warehouse.location', $request->status);
        }

        // Lọc theo warehouse_id (ID kho)
        if ($request->has('warehouse_id') && $request->warehouse_id) {
            $history->where('transfer_history.warehouse_id', $request->warehouse_id);
        }

        // Lọc theo product_id (ID sản phẩm)
        if ($request->has('product_id') && $request->product_id) {
            $history->where('transfer_history.product_id', $request->product_id);
        }

        // Lọc theo ngày từ và đến (date_from, date_to)
        if ($request->has('date_from') && $request->date_from) {
            $history->whereDate('transfer_history.created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $history->whereDate('transfer_history.created_at', '<=', $request->date_to);
        }

        // Lấy kết quả lịch sử
        $history = $history->get();

        // Trả về kết quả và các trường lọc
        return response()->json([
            'history' => $history,
        ]);
    }
}
