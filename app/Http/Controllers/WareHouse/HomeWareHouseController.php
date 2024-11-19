<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeWareHouseController extends Controller
{
    public function index_nhap_kho()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('ilsung.WareHouse.pages.NhapKho', compact('products', 'warehouses'));
    }


    public function index_xuat_kho()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('ilsung.WareHouse.pages.XuatKho', compact('products', 'warehouses'));
       
    }

    public function index_chuyen_kho()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('ilsung.WareHouse.pages.ChuyenKho', compact('products', 'warehouses'));
   }

   public function index_ton_kho()
   {
    $stockData = DB::table('product_warehouse')
    ->join('products', 'product_warehouse.product_id', '=', 'products.id')
    ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
    ->select('products.name as product', 'warehouses.name as warehouse', 'product_warehouse.quantity')
    ->get();
    return view('ilsung.WareHouse.pages.ChuyenKho', compact('stockData'));

  }

    public function index_master()
    {
        return view('ilsung.WareHouse.pages.update_master.index-data');
    }

    public function index_user()
    {
        return view('ilsung.pages.User-checklist');
    }

}
