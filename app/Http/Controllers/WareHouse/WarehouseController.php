<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\Product_warehouse;
use App\Models\WareHouse\StockMovement;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class WarehouseController extends Controller
{


    public function show_master_import(Request $request)
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return response()->json([
            'product' => $products,
            'warehouse' => $warehouses,

        ]);
    }

    public function show_master_export(Request $request)
    {
        $type = $request->input('Type'); // Lọc theo loại sản phẩm (nếu có)
        $query = Product::with('stockMovements.warehouse');
        $kho = Warehouse::all();
        $products_all = Product::all();
        if ($type && $type !== 'All') {
            $query->where('type', $type);
        }

        $products = $query->get();

        // Chuẩn bị dữ liệu kho
        $warehouses = Warehouse::all()->keyBy('id');
        $data = [];

        foreach ($products as $product) {
            foreach ($product->stockMovements as $stock) {
                $warehouse = $warehouses->get($stock->warehouse_id);
                if ($warehouse) {
                    // Kiểm tra nếu sản phẩm chưa có trong mảng dữ liệu
                    if (!isset($data[$product->id])) {
                        $data[$product->id] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'ID_SP' => $product->ID_SP,
                            'mage' => $product->Image,
                            'Type' => $product->Type,
                            'stock_movements' => [],
                        ];
                    }
                    // Thêm thông tin về kho vào sản phẩm
                    $data[$product->id]['stock_movements'][] = [
                        'warehouse_id' => $warehouse->id,
                        'warehouse_name' => $warehouse->name,
                        'available_qty' => $stock->quantity,
                    ];
                }
            }
        }

        return response()->json([
            'products' => $data, // Trả về dữ liệu đã nhóm theo sản phẩm
            'products_all' => $products_all, // Trả về dữ liệu đã nhóm theo sản phẩm
            'warehouse' => $kho,
        ]);
    }

    public function show_master_transfer(Request $request)
    {
        $type = $request->input('Type'); // Lọc theo loại sản phẩm (nếu có)
        $action = $request->input('action');
        $query = Product::with('stockMovements.warehouse');
        $kho = Warehouse::all();
        $products_all = Product::all();
        if ($type && $type !== 'All') {
            $query->where('type', $type);
        }

        $products = $query->get();

        // Chuẩn bị dữ liệu kho
        $warehouses = Warehouse::all()->keyBy('id');
        $data = [];

        foreach ($products as $product) {
            foreach ($product->stockMovements as $stock) {
                $warehouse = $warehouses->get($stock->warehouse_id);
                if ($warehouse) {
                    // Kiểm tra nếu sản phẩm chưa có trong mảng dữ liệu
                    if (!isset($data[$product->id])) {
                        $data[$product->id] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'ID_SP' => $product->ID_SP,
                            'Image' => $product->Image,
                            'Type' => $product->Type,
                            'stock_movements' => [],
                        ];
                    }
                    // Thêm thông tin về kho vào sản phẩm
                    $data[$product->id]['stock_movements'][] = [
                        'warehouse_id' => $warehouse->id,
                        'warehouse_name' => $warehouse->name,
                        'available_qty' => $stock->quantity,
                    ];
                }
            }
        }

        return response()->json([
            'products_search' => $data, // Trả về dữ liệu đã nhóm theo sản phẩm
            'products_all' => $products_all, // Trả về dữ liệu đã nhóm theo sản phẩm
            'warehouse' => $kho,
        ]);
    }


    public function search_master(Request $request)
    {
        $type = $request->input('Type') === 'All' ? null : $request->input('Type');
        $name = $request->input('name');
        $id_sp = $request->input('ID_SP');

        $query = Product::query();

        // Lọc theo ID_SP nếu được cung cấp
        if (!empty($id_sp)) {
            $product = $query->where('ID_SP', $id_sp)->first();
        } else {
            if ($type) {
                $query->where('Type', $type);
            }

            if (!empty($name)) {
                $query->where('name', $name);
            }

            $product = $query->first();
        }

        if ($product) {
            return response()->json([
                'type' => $product->Type,
                'name' => $product->name,
                'ID_SP' => $product->ID_SP,
            ]);
        } else {
            return response()->json(null, 404); // Không tìm thấy sản phẩm
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

    public function importStock(Request $request)
    {
        // Xác thực dữ liệu từ AJAX (mảng products)
        $request->validate([
            'products' => 'required|array|min:1', // Mảng sản phẩm phải có ít nhất một phần tử
            'products.*.From' => 'required', // Kiểm tra tồn tại kho chuyển (From)
            'products.*.warehouse_id' => 'required|exists:warehouses,id', // Kiểm tra tồn tại kho nhận (To)
            'products.*.quantity' => 'required|integer|min:1', // Kiểm tra số lượng nhập kho phải là số nguyên và >= 1
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                // Lưu lại sự kiện nhập kho cho mỗi sản phẩm
                Product_warehouse::create([
                    'product_id' => $product['product_id'],  // ID sản phẩm
                    'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                    'type' => 'import', // Loại sự kiện nhập kho
                    'quantity' => $product['quantity'], // Số lượng nhập
                    'Remark' => 'Nhập từ ' . $product['From'], // Số lượng nhập
                ]);

                // Cập nhật số lượng sản phẩm trong kho (kho chuyển)
                $productWarehouseFrom = DB::table('stock_movements')
                    ->where('product_id', $product['product_id'])
                    ->where('warehouse_id', $product['warehouse_id']);

                if ($productWarehouseFrom->exists()) {
                    // Nếu sản phẩm đã tồn tại trong kho chuyển, tăng số lượng
                    $productWarehouseFrom->increment('quantity', $product['quantity']);
                } else {
                    // Nếu sản phẩm chưa có trong kho chuyển, tạo mới bản ghi
                    DB::table('stock_movements')->insert([
                        'product_id' => $product['product_id'],
                        'warehouse_id' => $product['warehouse_id'],
                        'quantity' => $product['quantity'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return response()->json([
            'success' => 'Nhập kho thành công!',
            'status' => 200
        ]);
        // return redirect()->back()->with('success', 'Nhập kho thành công!');
    }

    public function exportStock(Request $request)
    {
        // Xác thực dữ liệu từ AJAX (mảng products)
        $request->validate([
            'products' => 'required|array|min:1', // Mảng sản phẩm phải có ít nhất một phần tử
            'products.*.To' => 'required', // Kiểm tra tồn tại kho chuyển (From)
            'products.*.warehouse_id' => 'required|exists:warehouses,id', // Kiểm tra tồn tại kho nhận (To)
            'products.*.quantity' => 'required|integer|min:1', // Kiểm tra số lượng nhập kho phải là số nguyên và >= 1
        ]);


        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                // Lưu lại sự kiện nhập kho cho mỗi sản phẩm
                $target_warehouse = Warehouse::find($product['To'])->name;

                Product_warehouse::create([
                    'product_id' => $product['product_id'],  // ID sản phẩm
                    'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                    'type' => 'export', // Loại sự kiện nhập kho
                    'quantity' => $product['quantity'], // Số lượng nhập
                    'Remark' => 'Xuất đi ' . $target_warehouse, // Số lượng nhập
                    'target_warehouse_id' => $product['To'], // Số lượng nhập
                ]);

                // Kiểm tra tồn kho
                $stock = DB::table('stock_movements')
                    ->where('product_id', $product['product_id'])
                    ->where('warehouse_id', $product['warehouse_id'])
                    ->first();

                // Giảm số lượng tồn kho

                if ($stock) {
                    // Kiểm tra số lượng tồn kho
                    if ($stock->quantity < $product['quantity']) {
                        return back()->withErrors(['error' => 'Số lượng tồn kho không đủ để xuất!']);
                    }

                    // Giảm số lượng tồn kho
                    DB::table('stock_movements')
                        ->where('product_id', $product['product_id'])
                        ->where('warehouse_id', $product['warehouse_id'])
                        ->decrement('quantity', $product['quantity']);
                } else {
                    // Không có tồn kho để xuất
                    return back()->withErrors(['error' => 'Không có tồn kho để xuất!']);
                }
            }
        });

        return response()->json([
            'success' => 'Xuất kho thành công!',
            'status' => 200
        ]);
        // return redirect()->back()->with('success', 'Nhập kho thành công!');
    }


    public function transferStock(Request $request)
    {

        $request->validate([
            'products' => 'required|array|min:1', // Mảng sản phẩm phải có ít nhất một phần tử
            'products.*.To' => 'required', // Kiểm tra tồn tại kho chuyển (From)
            'products.*.warehouse_id' => 'required|exists:warehouses,id', // Kiểm tra tồn tại kho nhận (To)
            'products.*.quantity' => 'required|integer|min:1', // Kiểm tra số lượng nhập kho phải là số nguyên và >= 1
            'products.*.action' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                // Lưu lại sự kiện nhập kho cho mỗi sản phẩm
                $target_warehouse = Warehouse::find($product['To'])->name;
                $action = $product['action'];

                Product_warehouse::create([
                    'product_id' => $product['product_id'],  // ID sản phẩm
                    'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                    'type' =>  $action, // Loại sự kiện nhập kho
                    'quantity' => $product['quantity'], // Số lượng nhập
                    'Remark' => $action . ' ' . $target_warehouse, // Số lượng nhập
                    'target_warehouse_id' => $product['To'], // Kho nhận (To)
                ]);

                if ($action != 'Import') {

                    // Kiểm tra tồn kho
                    $stock = DB::table('stock_movements')
                        ->where('product_id', $product['product_id'])
                        ->where('warehouse_id', $product['warehouse_id'])
                        ->first();

                    // Giảm số lượng tồn kho
                    if ($stock) {
                        // Kiểm tra số lượng tồn kho
                        if ($stock->quantity < $product['quantity']) {
                            return back()->withErrors(['error' => 'Số lượng tồn kho không đủ để xuất!']);
                        }

                        // Giảm số lượng tồn kho
                        DB::table('stock_movements')
                            ->where('product_id', $product['product_id'])
                            ->where('warehouse_id', $product['warehouse_id'])
                            ->decrement('quantity', $product['quantity']);
                    } else {
                        // Không có tồn kho để xuất
                        return back()->withErrors(['error' => 'Không có tồn kho để xuất!']);
                    }
                }

                if ($action == 'Import') {
                    // Tăng số lượng tại kho đích
                    $targetStock = DB::table('stock_movements')
                        ->where('product_id', $product['product_id'])
                        ->where('warehouse_id', $product['warehouse_id'])
                        ->first();

                    if ($targetStock) {
                        DB::table('stock_movements')
                            ->where('product_id', $product['product_id'])
                            ->where('warehouse_id', $product['To'])
                            ->increment('quantity', $product['quantity']);
                    } else {
                        DB::table('stock_movements')->insert([
                            'product_id' =>  $product['product_id'],
                            'warehouse_id' => $product['To'],
                            'quantity' => $product['quantity'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                if ($action == 'Transfer') {
                    // Tăng số lượng tại kho đích
                    $targetStock = DB::table('stock_movements')
                        ->where('product_id', $product['product_id'])
                        ->where('warehouse_id', $product['To'])
                        ->first();

                    if ($targetStock) {
                        DB::table('stock_movements')
                            ->where('product_id', $product['product_id'])
                            ->where('warehouse_id', $product['To'])
                            ->increment('quantity', $product['quantity']);
                    } else {
                        DB::table('stock_movements')->insert([
                            'product_id' =>  $product['product_id'],
                            'warehouse_id' => $product['To'],
                            'quantity' => $product['quantity'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        });

        return response()->json([
            'success' => 'thành công!',
            'status' => 200
        ]);
    }

    public function history_transfer(Request $request)
    {

        $request->validate([
            'products' => 'required|array|min:1', // Mảng sản phẩm phải có ít nhất một phần tử
            'products.*.To' => 'required', // Kiểm tra tồn tại kho chuyển (From)
            'products.*.warehouse_id' => 'required|exists:warehouses,id', // Kiểm tra tồn tại kho nhận (To)
            'products.*.quantity' => 'required|integer|min:1', // Kiểm tra số lượng nhập kho phải là số nguyên và >= 1
            'products.*.action' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->products as $product) {
                // Lưu lại sự kiện nhập kho cho mỗi sản phẩm
                $target_warehouse = Warehouse::find($product['To'])->name;
                $action = $product['action'];

                StockMovement::create([
                    'product_id' => $product['product_id'],  // ID sản phẩm
                    'warehouse_id' => $product['warehouse_id'], // Kho chuyển (From)
                    'type' =>  $action, // Loại sự kiện nhập kho
                    'quantity' => $product['quantity'], // Số lượng nhập
                    'Remark' => $action . ' ' . $target_warehouse, // Số lượng nhập
                    'target_warehouse_id' => $product['To'], // Kho nhận (To)
                ]);
            }
        });

        return response()->json([
            'success' => 'thành công!',
            'status' => 200
        ]);
    }


    public function showStock()
    {
        $stockData = DB::table('stock_view')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select('products.name as product', 'warehouses.name as warehouse', 'product_warehouse.quantity')
            ->get();

        return view('warehouse.stock', compact('stockData'));
    }



    public function getStock(Request $request)
    {
        // Khởi tạo query
        $query_warehouse = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id') // Kết nối với bảng products để lấy tên sản phẩm
            ->join('warehouses', 'stock_movements.warehouse_id', '=', 'warehouses.id')
            ->select(
                'stock_movements.product_id',
                'products.name as product_name',
                'products.ID_SP',
                'products.Image',
                'products.Type', // Lấy type từ bảng stock_movements
                'stock_movements.warehouse_id',
                'warehouses.name as warehouse_name',
                DB::raw('SUM(stock_movements.quantity) as stock')
            )

            ->groupBy('stock_movements.product_id', 'products.name', 'products.Type', 'stock_movements.warehouse_id',  'products.Image', 'warehouse_name', 'products.ID_SP');

        $query_products = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id') // Kết nối với bảng products
            ->join('warehouses', 'stock_movements.warehouse_id', '=', 'warehouses.id') // Kết nối với bảng warehouses
            ->select(
                'stock_movements.product_id',
                'products.name as product_name',
                'products.ID_SP',
                'products.Image',
                'products.stock_limit',
                'products.Type', // Lấy type từ bảng products
                DB::raw('GROUP_CONCAT(CONCAT(warehouses.name, " (", stock_movements.quantity, ")") SEPARATOR "\n") as warehouses'), // Gộp danh sách kho
                DB::raw('SUM(stock_movements.quantity) as stock') // Tính tổng tồn kho
            )
            ->groupBy('stock_movements.product_id', 'products.name', 'products.Type', 'products.Image',  'products.stock_limit', 'products.ID_SP') // Gộp theo sản phẩm
            ->havingRaw('SUM(stock_movements.quantity) >= 0'); // Bao gồm cả sản phẩm có số lượng bằng 0



        $warehouses = DB::table('stock_movements')
            ->join('warehouses', 'stock_movements.warehouse_id', '=', 'warehouses.id')
            ->join('products', 'stock_movements.product_id', '=', 'products.id') // Kết nối với bảng products để lấy type
            ->select(
                'stock_movements.warehouse_id',
                'warehouses.name',
                DB::raw('SUM(stock_movements.quantity) as total_stock')
            )
            ->groupBy('stock_movements.warehouse_id', 'warehouses.name')
            ->havingRaw('SUM(stock_movements.quantity) > 0'); // Chỉ lấy những kho có tồn kho > 0

        // Lấy danh sách các sản phẩm và loại sản phẩm (tự động lọc theo stock > 0)
        $products = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id')
            ->join('warehouses', 'stock_movements.warehouse_id', '=', 'warehouses.id')
            ->select(
                'stock_movements.product_id',
                'products.name',
                'products.Type',
                'products.ID_SP',
            )
            ->groupBy('stock_movements.product_id', 'products.name', 'products.Type', 'products.ID_SP')
            ->havingRaw('SUM(stock_movements.quantity) > 0');


        // Lọc theo type (loại sản phẩm)
        if ($request->has('type') && $request->type != 'All') {
            $query_products->where('products.Type', $request->type); // Lọc theo type trong bảng stock_movements
            $products->where('products.Type', $request->type);
        }

        // Lọc theo kho (warehouse)
        if ($request->has('warehouse') && $request->warehouse) {
            $query_warehouse->where('stock_movements.warehouse_id', $request->warehouse);
        }
        // Lọc theo product_id (ID sản phẩm)
        if ($request->has('product_id') && $request->product_id) {
            $query_products->where('stock_movements.product_id', $request->product_id);
            $products->where('stock_movements.product_id', $request->product_id);
        }

        // Lọc theo tên sản phẩm
        if ($request->has('name') && $request->name) {
            $query_products->where('stock_movements.product_id', $request->product_id);
            $products->where('stock_movements.product_id', $request->product_id);
        }

        // Lấy kết quả stock
        $stock = $query_products->orderBy('Type')->get();
        $stock_kho = $query_warehouse->orderBy('warehouse_name')->get();
        $warehouses = $warehouses->get();
        $products = $products->get();
        // Lấy danh sách các kho (tự động lọc theo stock > 0)


        // Truy vấn danh sách type
        $types = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id')
            ->select('products.type')
            ->havingRaw('SUM(stock_movements.quantity) > 0') // Chỉ lấy những sản phẩm có tồn kho > 0
            ->groupBy('products.type') // Nhóm theo loại sản phẩm
            ->get();

        // Trả về kết quả và các trường lọc
        return response()->json([
            'stock' => $stock,
            'stock_kho' => $stock_kho,
            'warehouses' => $warehouses,
            'products' => $products,
            'Type' => $types
        ]);
    }
    public function getHistory(Request $request)
    {
        $productId = $request->input('product_id');

        // Lấy lịch sử nhập/xuất của sản phẩm
        $history = DB::table('stock_movements')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->leftJoin('warehouses as from_warehouse', 'product_warehouse.warehouse_id', '=', 'from_warehouse.id')
            ->leftJoin('warehouses as to_warehouse', 'product_warehouse.target_warehouse_id', '=', 'to_warehouse.id')
            ->select(
                'product_warehouse.*',
                'products.ID_SP',
                'products.id',
                'products.Image',
                'products.name as product_name',
                'from_warehouse.name as from_warehouse_name',
                'to_warehouse.name as to_warehouse_name'
            )
            ->when($productId, function ($query) use ($productId) {
                return $query->where('product_warehouse.product_id', $productId);
            })
            ->orderBy('product_warehouse.created_at', 'desc')
            ->get();

        // Lấy chi tiết tồn kho của sản phẩm tại các kho
        $stockDetails = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id')
            ->join('warehouses', 'stock_movements.warehouse_id', '=', 'warehouses.id')
            ->select(
                'stock_movements.product_id',
                'products.name as product_name',
                'products.ID_SP',
                'products.Image',
                'warehouses.name as warehouse_name',
                DB::raw('SUM(stock_movements.quantity) as stock')
            )
            ->where('stock_movements.product_id', $productId)
            ->groupBy('stock_movements.product_id', 'products.name', 'products.ID_SP', 'products.Image', 'warehouses.name')
            ->get();

        // Kết hợp dữ liệu lịch sử và thông tin tồn kho
        $response = [
            'history' => $history,
            'stock_details' => $stockDetails
        ];

        return response()->json($response);
    }
    public function getHistorydata(Request $request)
    {

        // Lấy lịch sử nhập/xuất của sản phẩm
        $history = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id')
            ->leftJoin('warehouses as from_warehouse', 'stock_movements.warehouse_id', '=', 'from_warehouse.id')
            ->leftJoin('warehouses as to_warehouse', 'stock_movements.target_warehouse_id', '=', 'to_warehouse.id')
            ->select(
                'stock_movements.*',
                'products.ID_SP',
                'products.name as product_name',
                'from_warehouse.name as from_warehouse_name',
                'to_warehouse.name as to_warehouse_name'
            )
            ->orderBy('stock_movements.created_at', 'desc')
            ->get();
        $response = [
            'history' => $history,
        ];

        return response()->json($response);
    }

    function get_search(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $offset = ($page - 1) * $pageSize;

        // Truy vấn với offset và giới hạn
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

        return response()->json([
            'products' => $products,
            'hasMore' => ($page * $pageSize) < $totalCount
        ]);
    }

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
}
