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
