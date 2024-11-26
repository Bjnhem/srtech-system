<?php

namespace App\Http\Controllers\OQC;

use App\Http\Controllers\Controller;
use App\Models\OQC\ErrorList;
use App\Models\OQC\Plan;
use App\Models\WareHouse\Product;
use App\Models\WareHouse\Warehouse;
use Illuminate\Http\Request;

class HomeOQCController extends Controller
{
    public function index_plan()
    {
        $Plan = Plan::all();
        $Item_loss = ErrorList::all();
        return view('ilsung.OQC.pages.OQC-plan', compact('Plan', 'Item_loss'));
        // return view('ilsung.OQC.pages.OQC-plan');
    }


    public function index_loss()
    {
        // $products = Product::all();
        // $warehouses = Warehouse::all();
        // return view('ilsung.WareHouse.pages.XuatKho', compact('products', 'warehouses'));
        return view('ilsung.OQC.pages.OQC-loss');
    }

    public function index_feedback()
    {
        // $products = Product::all();
        // $warehouses = Warehouse::all();
        // return view('ilsung.WareHouse.pages.ChuyenKho', compact('products', 'warehouses'));
        return view('ilsung.OQC.pages.OQC-feedback');
    }


    public function index_master()
    {
        return view('ilsung.OQC.pages.update_master.index-data');
    }

    public function index_user()
    {
        return view('ilsung.pages.User-checklist');
    }
}
