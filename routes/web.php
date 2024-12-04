<?php

// Controllers

use App\Http\Controllers\admin_check_list_controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataTbaleController;
use App\Http\Controllers\AdminController as ControllersAdminController;
use App\Http\Controllers\checklist\ChecklistController;
use App\Http\Controllers\checklist\HomeChecklistController;
use App\Http\Controllers\checklist\HomeController as ChecklistHomeController;
use App\Http\Controllers\checklist\PlanController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OQC\HomeOQCController;
use App\Http\Controllers\OQC\OQCController;
use App\Http\Controllers\OQC\OQCLosssController;
use App\Http\Controllers\OQC\UpdateDataOQCController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\UpdatedataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WareHouse\HomeWareHouseController;
use App\Http\Controllers\WareHouse\UpdateDataWarehouseController;
use App\Http\Controllers\WareHouse\WarehouseController;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//UI Pages Routs
// Route::get('/', [HomeController::class, 'uisheet'])->name('uisheet');


// Home controller
Route::group(['middleware' => 'auth'], function () {
    //router home
    Route::get('/', [HomeController::class, 'Home_index'])->name('Home.index');
    Route::get('/warehouse', [HomeController::class, 'Home_WareHouse'])->name('Home.WareHouse');
    Route::get('/OQC', [OQCLosssController::class, 'showSummary'])->name('Home.OQC');
    Route::get('/Checklist', [HomeController::class, 'Home_checklist'])->name('Home.checklist');


    Route::get('/change-language/{language}', [HomeController::class, 'changeLanguage'])->name('change-language'); // router change ngôn ngữ

    // Permission Module
    Route::get('/role-permission', [RolePermission::class, 'index'])->name('role.permission.list');
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'Home_index'])->name('dashboard');

    // Users Module
    Route::resource('users', UserController::class);
});

// Route checklist

Route::middleware('auth')->prefix('Checklist')->group(function () {
    // Route::get('/overview', [HomeController::class, 'Home_checklist'])->name('checklist.overview');
    Route::get('/Overview-data', [HomeChecklistController::class, 'overview_data'])->name('checklist.overview.data');
    Route::get('/Check', [HomeChecklistController::class, 'index_checklist'])->name('Check.checklist');
    Route::get('/Plan', [HomeChecklistController::class, 'index_plan'])->name('Plan.checklist');
    Route::get('/Master', [HomeChecklistController::class, 'index_master'])->name('update.master');
    Route::get('/User', [HomeChecklistController::class, 'index_user'])->name('user.checklist');
});


Route::prefix('Checklist/Check')->group(function () {
    Route::get('show/{line}', [ChecklistController::class, 'index_checklist_show'])->name('show.checklist');
    Route::get('/checklist-masster', [ChecklistController::class, 'check_list_masster'])->name('check.list.masster');  // show model search
    Route::get('/item-check', [ChecklistController::class, 'Machine_ID_search'])->name('item.checklist.search');  // show model search
    Route::get('/khung-gio-check', [ChecklistController::class, 'Khung_check'])->name('khung.check.search');  // show model search

    Route::post('/Check-Machine-ID', [ChecklistController::class, 'Check_machine_ID'])->name('check.machine');




    Route::post('/check-list-overview', [ChecklistController::class, 'search_check_list_overview'])->name('check.list.overview');  // show model search
    Route::delete('/checklist/{id}', [ChecklistController::class, 'delete_check_list'])->name('delete.check.list');


    Route::get('/check-list-show', [ChecklistController::class, 'check_list_detail'])->name('check.list.search');  // show model search
    Route::get('/check-list-edit', [ChecklistController::class, 'check_list_edit_detail'])->name('check.list.edit.search');  // show model search
    Route::post('/save-check-list/{table}', [ChecklistController::class, 'save_check_list'])->name('save.check.list');  // show model search
    Route::post('/save-check-list-detail/{table}', [ChecklistController::class, 'save_check_list_detail'])->name('save.check.list.detail');  // show model search
    Route::post('/update-check-list-detail/{table}', [ChecklistController::class, 'update_check_list_detail'])->name('update.check.list.detail');  // show model search
    Route::post('/search-check-list', [ChecklistController::class, 'search_check_list'])->name('search.check.list');  // show model search
    Route::post('/search-check-list-view', [ChecklistController::class, 'search_check_list_view'])->name('search.check.list.view');  // show model search
    Route::post('/edit-table/{model}', [ChecklistController::class, 'edit_table'])->name('check.list.edit.data');
    Route::post('/edit-check-list', [ChecklistController::class, 'save_edit_check_list'])->name('save.edit.check.list');  // show model search
    Route::get('/delete-check-list', [ChecklistController::class, 'delete_row'])->name('check.list.delete');
});

Route::prefix('Checklist/Plan')->group(function () {
    Route::post('/add-plan', [PlanController::class, 'created_plan_checklist'])->name('add.plan.checklist');
    Route::post('/delete-plan', [PlanController::class, 'delete_plan_checklist'])->name('delete.plan.checklist');
    Route::post('/show-plan', [PlanController::class, 'show_plan_checklist'])->name('show.plan.checklist');
    Route::post('/check-list-plan', [PlanController::class, 'search_check_list_overview'])->name('check.list.overview');  // show model search 
    Route::get('/api/events', [PlanController::class, 'show_plan'])->name('show.plan');
});

Route::prefix('Checklist/Master')->group(function () {

    Route::get('/data-checklist', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_checklist'])->name('update.data.checklist');
    Route::get('/data-line', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_line'])->name('update.data.line');
    Route::get('/data-model', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_model'])->name('update.data.model');
    Route::get('/data-machine', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_machine'])->name('update.data.machine');
    Route::get('/data-machine-list', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_machine_list'])->name('update.data.machine.list');
    Route::get('/data-machine-master', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_machine_master'])->name('update.data.machine.master');
    Route::get('/show-data-table_machine', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_machine'])->name('update.show.data.machine');


    Route::get('/data-checklist-master', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_checklist_master'])->name('update.data.checklist.master');
    Route::get('/show-data-table-checklist-master', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_checklist_master'])->name('update.show.data.checklist.master');

    Route::get('/data-checklist-item', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_checklist_item'])->name('update.data.checklist.item');
    Route::get('/show-data-table-checklist-item', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_checklist_item'])->name('update.show.data.checklist.item');
    Route::get('/data-checklist-item_search', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_item_master'])->name('update.data.item_check');




    Route::get('/show-model', [DataTableController::class, 'show'])->name('update.show.model');
    Route::post('/edit-table/{model}', [DataTableController::class, 'edit_table'])->name('update.edit.data');
    Route::get('/show-data-table', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table'])->name('update.show.data');
    Route::post('/delete-data-table', [\App\Http\Controllers\checklist\UpdateDataController::class, 'delete_data_row_table'])->name('update.delete.data');
    Route::post('/add-data-table', [\App\Http\Controllers\checklist\UpdateDataController::class, 'add_data_row_table'])->name('update.add.data');
});



// Route WareHouse

Route::middleware('auth')->prefix('WareHouse')->group(function () {

    // Route nhập kho
    Route::get('/Nhap-kho', [HomeWareHouseController::class, 'index_nhap_kho'])->name('WareHouse.nhap.kho');
    Route::get('/show-master-import', [WarehouseController::class, 'show_master_import'])->name('WareHouse.show.master');
    Route::get('/search-master-import', [WarehouseController::class, 'search_master'])->name('WareHouse.show.product.infor');
    Route::post('/import', [WarehouseController::class, 'importStock'])->name('warehouse.import');

    // Route xuất kho
    Route::get('/Xuat-kho', [HomeWareHouseController::class, 'index_xuat_kho'])->name('WareHouse.xuat.kho');
    Route::get('/show-master-export', [WarehouseController::class, 'show_master_export'])->name('WareHouse.show.master.export');
    Route::get('/search-master-export', [WarehouseController::class, 'search_master'])->name('WareHouse.show.product.infor.export');
    Route::post('/export', [WarehouseController::class, 'exportStock'])->name('warehouse.export');

    // Route xuất kho
    // Route::get('/chuyen-kho', [HomeWareHouseController::class, 'index_xuat_kho'])->name('WareHouse.chuyen.kho');
    // Route::get('/show-master-transfer', [WarehouseController::class, 'show_master_transfer'])->name('WareHouse.show.master.transfer');
    // Route::get('/search-master-export', [WarehouseController::class, 'search_master'])->name('WareHouse.show.product.infor.export');
    Route::post('/transfer', [WarehouseController::class, 'transferStock'])->name('warehouse.transfer');

    // Route nhập xuất
    Route::get('/nhap-xuat', [HomeWareHouseController::class, 'index_chuyen_kho'])->name('WareHouse.chuyen.kho');
    Route::get('/show-master-transfer', [WarehouseController::class, 'show_master_transfer'])->name('WareHouse.show.master.transfer');
    Route::post('/transfer', [WarehouseController::class, 'transferStock'])->name('warehouse.transfer');



    // Route::get('/Chuyen-kho', [HomeWareHouseController::class, 'index_chuyen_kho'])->name('WareHouse.chuyen.kho');
    Route::post('/transfer', [WarehouseController::class, 'transferStock'])->name('warehouse.transfer');

    Route::get('/stock', [HomeWareHouseController::class, 'index_ton_kho'])->name('warehouse.stock');
    Route::get('/stock-data', [WarehouseController::class, 'getStock'])->name('warehouse.stock.data');
    Route::get('/stock-data-detail', [WarehouseController::class, 'getHistory'])->name('warehouse.stock.data.history');
    Route::get('/stock-data-history', [WarehouseController::class, 'getHistorydata'])->name('warehouse.data.history');

    Route::get('/Master', [HomeWareHouseController::class, 'index_master'])->name('WareHouse.update.master');
    Route::get('/User', [HomeWareHouseController::class, 'index_user'])->name('user.checklist');
});



Route::prefix('WareHouse/Master')->group(function () {

    Route::get('/data-sanpham', [UpdateDataWarehouseController::class, 'data_sanpham'])->name('Warehouse.update.data.sanpham');
    Route::get('/data-kho', [UpdateDataWarehouseController::class, 'data_kho'])->name('Warehouse.update.data.kho');
    Route::get('/data-model', [UpdateDataWarehouseController::class, 'data_model'])->name('Warehouse.update.data.model');
    Route::post('/upload-csv', [UpdateDataWarehouseController::class, 'update_table'])->name('Warehouse.table.update.data');


    // Route::get('/show-data-table_machine', [UpdateDataWarehouseController::class, 'show_data_table_machine'])->name('update.show.data.machine');

    Route::get('/data-checklist-master', [UpdateDataWarehouseController::class, 'data_checklist_master'])->name('update.data.checklist.master');
    Route::get('/show-data-table-checklist-master', [UpdateDataWarehouseController::class, 'show_data_table_checklist_master'])->name('update.show.data.checklist.master');



    Route::get('/data-checklist-item', [UpdateDataWarehouseController::class, 'data_checklist_item'])->name('update.data.checklist.item');
    Route::get('/show-data-table-checklist-item', [UpdateDataWarehouseController::class, 'show_data_table_checklist_item'])->name('update.show.data.checklist.item');
    Route::get('/data-checklist-item_search', [UpdateDataWarehouseController::class, 'data_item_master'])->name('update.data.item_check');



    Route::get('/search-product', [UpdateDataWarehouseController::class, 'search'])->name('product.search');
    Route::get('/show-data-table-product', [UpdateDataWarehouseController::class, 'showData'])->name('Warehouse.update.show.data.product');
    Route::post('/product/save', [UpdateDataWarehouseController::class, 'store_products'])->name('product.save');
    Route::get('/show-model', [DataTableController::class, 'show'])->name('update.show.model');
    Route::post('/edit-table/{model}', [DataTableController::class, 'edit_table'])->name('update.edit.data');
    Route::get('/show-data-table', [UpdateDataWarehouseController::class, 'show_data_table'])->name('Warehouse.update.show.data');
    Route::post('/add-data-table', [UpdateDataWarehouseController::class, 'add_data_row_table'])->name('Warehouse.update.add.data');
    Route::post('/delete-data-table', [UpdateDataWarehouseController::class, 'delete_data_row_table'])->name('Warehouse.update.delete.data');
});

// Route OQC

Route::middleware('auth')->prefix('OQC')->group(function () {

    // Route nhập data
    Route::get('/Nhap-plan', [HomeOQCController::class, 'index_plan'])->name('OQC.plan');
    Route::get('/Nhap-loss', [HomeOQCController::class, 'index_loss'])->name('OQC.loss');
    Route::get('/Data-loss-detail', [HomeOQCController::class, 'index_loss_detail'])->name('OQC.loss.detail');
    Route::get('/feedback', [HomeOQCController::class, 'index_feedback'])->name('OQC.feedback');
    Route::get('/Master', [HomeWareHouseController::class, 'index_master'])->name('OQC.update.master');
    Route::get('/User', [HomeWareHouseController::class, 'index_user'])->name('user.checklist');
});

Route::prefix('OQC/Master')->group(function () {

    Route::get('', [HomeOQCController::class, 'index_master'])->name('OQC.update.master');
    Route::get('/data-model', [UpdateDataOQCController::class, 'data_model'])->name('OQC.update.data.model');
    Route::get('/data-line', [UpdateDataOQCController::class, 'data_line'])->name('OQC.update.data.line');
    Route::post('/upload-csv', [UpdateDataWarehouseController::class, 'update_table'])->name('OQC.table.update.data');

    // route nhập data loss
    Route::get('/plan/data', [OQCLosssController::class, 'getPlanData'])->name('OQC.loss.data.plan');
    Route::get('/plan/dropdown', [OQCLosssController::class, 'getDropdownData'])->name('OQC.loss.data.plan.search');
    Route::get('/plan/prod-qty', [OQCLosssController::class, 'getProdQty'])->name('OQC.loss.data.plan.search.prod.qty');
    Route::get('/show-data-table-loss-detail', [OQCLosssController::class, 'showData_loss_detail'])->name('OQC.update.show.data.loss.detail');
    Route::get('/show-data-table-loss-detail-2', [OQCLosssController::class, 'showData_loss_detail_2'])->name('OQC.update.show.data.loss.detail2');
    Route::post('/add-data-table-loss', [OQCLosssController::class, 'add_data_row_table'])->name('OQC.update.add.data.loss.detail');
    Route::post('/delete-data-table-loss', [OQCLosssController::class, 'delete_data_row_table'])->name('OQC.update.delete.data.loss.detail');
    Route::get('/get-data_loss_search', [OQCLosssController::class, 'data_loss_search'])->name('OQC.loss.search');

    // Route trang imap_fetch_overview
    Route::get('/get-data_overview', [OQCLosssController::class, 'calculateSummary'])->name('OQC.caculate.overview');
    Route::get('/oqc/data', [OQCLosssController::class, 'getData'])->name('oqc.data');
    Route::get('/oqc/data-defect', [OQCLosssController::class, 'show_loss_list'])->name('oqc.data.defect');


    // route update plan
    Route::get('/show-data-table-plan', [UpdateDataOQCController::class, 'showData'])->name('OQC.update.show.data.plan');
    Route::post('/plan/save', [UpdateDataOQCController::class, 'store_plan'])->name('plan.save');
    Route::post('/upload-plan', [UpdateDataOQCController::class, 'updateFromExcel'])->name('OQC.table.update.data');
    Route::get('/show-data-master', [UpdateDataOQCController::class, 'getdata_plan'])->name('OQC.table.update.data.show');


    // Route upload data excel
    Route::get('/download-template/{file_name}', [UpdateDataOQCController::class, 'downloadTemplate'])->name('OQC.download.template');



    // route upload loss item
    Route::get('/data-loss', [UpdateDataOQCController::class, 'data_loss'])->name('OQC.update.data.loss');
    Route::get('/show-data-table-loss', [UpdateDataOQCController::class, 'showData_Loss'])->name('OQC.update.show.data.loss');
    Route::get('/show-loss-item', [UpdateDataOQCController::class, 'showData_item'])->name('OQC.show.data.loss.item');
    Route::post('/upload-loss-item', [UpdateDataOQCController::class, 'updateFromExcel_loss'])->name('OQC.update.loss.item');
    Route::post('/loss/save', [UpdateDataOQCController::class, 'store_plan'])->name('OQC.loss.save');


    // rote update theo form
    Route::get('/show-data-table', [UpdateDataOQCController::class, 'show_data_table'])->name('OQC.update.show.data');
    Route::post('/add-data-table', [UpdateDataOQCController::class, 'add_data_row_table'])->name('OQC.update.add.data');
    Route::post('/delete-data-table', [UpdateDataOQCController::class, 'delete_data_row_table'])->name('OQC.update.delete.data');







    // Route::get('/show-data-table_machine', [UpdateDataWarehouseController::class, 'show_data_table_machine'])->name('update.show.data.machine');
    Route::get('/data-checklist-master', [UpdateDataWarehouseController::class, 'data_checklist_master'])->name('update.data.checklist.master');
    Route::get('/show-data-table-checklist-master', [UpdateDataWarehouseController::class, 'show_data_table_checklist_master'])->name('update.show.data.checklist.master');


    Route::get('/data-checklist-item', [UpdateDataWarehouseController::class, 'data_checklist_item'])->name('update.data.checklist.item');
    Route::get('/show-data-table-checklist-item', [UpdateDataWarehouseController::class, 'show_data_table_checklist_item'])->name('update.show.data.checklist.item');
    Route::get('/data-checklist-item_search', [UpdateDataWarehouseController::class, 'data_item_master'])->name('update.data.item_check');



    Route::get('/search-product', [UpdateDataWarehouseController::class, 'search'])->name('product.search');

    Route::get('/show-model', [DataTableController::class, 'show'])->name('update.show.model');
});





















//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function () {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
Route::group(['prefix' => 'special-pages'], function () {
    //Example Page Routs
    Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
    Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
    Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
    Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
    Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
});

//Widget Routs
Route::group(['prefix' => 'widget'], function () {
    Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
    Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
    Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
});

//Maps Routs
Route::group(['prefix' => 'maps'], function () {
    Route::get('google', [HomeController::class, 'google'])->name('maps.google');
    Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function () {
    Route::get('signin', [HomeController::class, 'signin'])->name('auth.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function () {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});


//Forms Pages Routs
Route::group(['prefix' => 'forms'], function () {
    Route::get('element', [HomeController::class, 'element'])->name('forms.element');
    Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
    Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
});


//Table Page Routs
Route::group(['prefix' => 'table'], function () {
    Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
});

//Icons Page Routs
Route::group(['prefix' => 'icons'], function () {
    Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
    Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
    Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
    Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
});
//Extra Page Routs
Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');
