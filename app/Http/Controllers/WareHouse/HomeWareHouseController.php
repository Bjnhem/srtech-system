<?php

namespace App\Http\Controllers\WareHouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeWareHouseController extends Controller
{
    public function index_nhap_kho()
    {
        return view('ilsung.WareHouse.pages.NhapKho');
    }


    public function index_xuat_kho()
    {
        return view('ilsung.WareHouse.pages.XuatKho');
    }

    public function index_chuyen_kho()
    {
        return view('ilsung.WareHouse.pages.ChuyenKho');
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
