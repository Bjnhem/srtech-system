<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        //return view('login');
    }
    public function login()
    {
        return view('smart-ver2.admin.login');
    }
    public function index()

    {
        $view='ftg';
        return view('Checklist_EQM.admin.check-list.admin-checklist', compact('view'));
    }
  
    public function index_search()
    {
        $view='pad';
        return view('Checklist_EQM.admin.check-list.admin-checklist-search',compact('view'));
    } 
    public function index_historry()
    {
        $view='pad';
        return view('Checklist_EQM.admin.check-list.add-checklist-historry',compact('view'));
    } 
    public function index_pending()
    {
        $view='ftg';
        return view('Checklist_EQM.admin.check-list.admin-checklist-overview', compact('view'));
    } 
    
    public function index_edit()
    {
        $view='ftg';
        return view('Checklist_EQM.admin.check-list.admin-checklist-edit',compact('view'));
    }
    public function index_check_list()
    {
        $view='ftg';
        return view('Checklist_EQM.admin.check-list.admin-checklist',compact('view'));
    }
    
    
}