<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeWareHouseController extends Controller
{
    public function index_history()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('srtech.WareHouse.pages.history', compact('products', 'warehouses'));
    }

   public function index_nhap_xuat()
   {
       $products = Product::all();
       $warehouses = Warehouse::all();
       return view('srtech.WareHouse.pages.nhap-xuat', compact('products', 'warehouses'));
  }

   public function index_ton_kho()
   {
  
    return view('srtech.WareHouse.pages.Stock');

  }

    public function index_master()
    {
        return view('srtech.WareHouse.pages.update_master.index-data');
    }



    public function index_user()
    {
        return view('srtech.warehouse.pages.user.user');
    }

}
