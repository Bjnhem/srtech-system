<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockByProduct;
use App\Models\StockByWarehouse;
use App\Models\StockByDetail;

use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
    // Phương thức để lấy dữ liệu cho Tab "By Product"
    public function getStockByProduct(Request $request)
    {
        $query = StockByProduct::query();

        // Thêm các điều kiện lọc vào query
        if ($request->has('type') && $request->type != 'All') {
            $query->where('type', $request->type);
        }

        if ($request->has('id_sp') && $request->id_sp != '') {
            $query->where('product_id', $request->id_sp);
        }

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lấy dữ liệu
        $data = $query->get();

        return response()->json($data);
    }

    // Phương thức để lấy dữ liệu cho Tab "By Warehouse"
    public function getStockByWarehouse(Request $request)
    {
        $query = DB::table('stock_by_warehouse')
        ->join('warehouses', 'stock_by_warehouse.warehouse_id', '=', 'warehouses.id')
        ->select('stock_by_warehouse.*', 'warehouses.name', 'warehouses.id', 'warehouses.location');

    
        // $query = StockByWarehouse::query();

        // Thêm các điều kiện lọc vào query
        if ($request->has('location') && $request->location != 'All') {
            $query->where('location', $request->location);
        }

      
        if ($request->has('name') && $request->name != '') {
            $query->where('warehouse_name', 'like', '%' . $request->name . '%');
        }

        // Lấy dữ liệu
        $data = $query->get();

        return response()->json($data);
    }

    // Phương thức để lấy dữ liệu cho Tab "By Detail"
    public function getStockByDetail(Request $request)
    {
        $query = StockByDetail::query();

        // Thêm các điều kiện lọc vào query
        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('warehouse_id') && $request->warehouse_id != '') {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Lấy dữ liệu
        $data = $query->get();

        return response()->json($data);
    }
}
