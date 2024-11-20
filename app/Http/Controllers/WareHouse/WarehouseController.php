<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\StockMovement;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class WarehouseController extends Controller
{


    public function show_master(Request $request)
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return response()->json([
            'product' => $products,
            'warehouse' => $warehouses,

        ]);
    }

    // public function search_master(Request $request)
    // {
    //     $type = ($request->input('Type') == 'All') ? null : $request->input('Type');
    //     $name = $request->input('name');
    //     $id_sp = $request->input('ID_SP');

    //     $query = Product::query();

    //     if (!empty($id_sp)) {
    //         $query->where('ID_SP', $id_sp);
    //     } else {

    //         if ($type !== null) {
    //             $query->where('Type', $type);
    //         }

    //         // Chỉ lọc theo Model nếu Model không phải là null
    //         if ($name !== null) {
    //             $query->where('name', $name);
    //         }
    //     }

    //     $type = $query->Type;
    //     $name = $query->name;
    //     $ID_SP = $query->ID_SP;

    //     return response()->json([
    //         'type' => $type,
    //         'name' => $name,
    //         'ID_SP' => $ID_SP,

    //     ]);
    // }

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





    public function showStock()
    {
        $stockData = DB::table('product_warehouse')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select('products.name as product', 'warehouses.name as warehouse', 'product_warehouse.quantity')
            ->get();

        return view('warehouse.stock', compact('stockData'));
    }

    public function importStock(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            StockMovement::create([
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'],
                'type' => 'import',
                'quantity' => $data['quantity'],
            ]);

            $productWarehouse = DB::table('product_warehouse')
                ->where('product_id', $data['product_id'])
                ->where('warehouse_id', $data['warehouse_id']);

            if ($productWarehouse->exists()) {
                $productWarehouse->increment('quantity', $data['quantity']);
            } else {
                DB::table('product_warehouse')->insert([
                    'product_id' => $data['product_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'quantity' => $data['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function exportStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $warehouseId = $request->warehouse_id;
        $quantity = $request->quantity;

        // Kiểm tra tồn kho
        $stock = DB::table('product_warehouse')
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->first();

        if (!$stock || $stock->quantity < $quantity) {
            return back()->withErrors(['error' => 'Số lượng tồn kho không đủ để xuất!']);
        }

        // Giảm số lượng tồn kho
        DB::table('product_warehouse')
            ->where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->decrement('quantity', $quantity);

        return redirect()->route('warehouse.stock')->with('success', 'Xuất kho thành công!');
    }

    public function transferStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'source_warehouse_id' => 'required|exists:warehouses,id',
            'target_warehouse_id' => 'required|exists:warehouses,id|different:source_warehouse_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $sourceWarehouseId = $request->source_warehouse_id;
        $targetWarehouseId = $request->target_warehouse_id;
        $quantity = $request->quantity;

        // Kiểm tra tồn kho ở kho nguồn
        $sourceStock = DB::table('product_warehouse')
            ->where('product_id', $productId)
            ->where('warehouse_id', $sourceWarehouseId)
            ->first();

        if (!$sourceStock || $sourceStock->quantity < $quantity) {
            return back()->withErrors(['error' => 'Số lượng tồn kho tại kho nguồn không đủ để chuyển!']);
        }

        // Giảm số lượng tại kho nguồn
        DB::table('product_warehouse')
            ->where('product_id', $productId)
            ->where('warehouse_id', $sourceWarehouseId)
            ->decrement('quantity', $quantity);

        // Tăng số lượng tại kho đích
        $targetStock = DB::table('product_warehouse')
            ->where('product_id', $productId)
            ->where('warehouse_id', $targetWarehouseId)
            ->first();

        if ($targetStock) {
            DB::table('product_warehouse')
                ->where('product_id', $productId)
                ->where('warehouse_id', $targetWarehouseId)
                ->increment('quantity', $quantity);
        } else {
            DB::table('product_warehouse')->insert([
                'product_id' => $productId,
                'warehouse_id' => $targetWarehouseId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('warehouse.stock')->with('success', 'Chuyển kho thành công!');
    }
}
