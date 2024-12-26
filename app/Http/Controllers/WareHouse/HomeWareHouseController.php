<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use App\Models\Model_master;
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

       return view('srtech.WareHouse.pages.nhap-xuat');
  }

  public function index_nhap_xuat_excel()
  {

      return view('srtech.WareHouse.pages.nhap-xuat-excel');
 }


   public function index_ton_kho()
   {
  
    return view('srtech.WareHouse.pages.Stock');

  }

    public function index_master()
    {
        $modelCount = Model_master::count();
        $warehouseCount = Warehouse::count();
        $productCount = Product::count();

        // Truyền dữ liệu vào view
        return view('srtech.WareHouse.pages.master-data', compact('modelCount', 'warehouseCount', 'productCount'));
      
    }

}
