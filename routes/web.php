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
    Route::get('/OQC', [HomeController::class, 'Home_OQC'])->name('Home.OQC');
    Route::get('/Checklist', [HomeController::class, 'Home_checklist'])->name('Home.checklist');


    Route::get('/change-language/{language}', [HomeController::class, 'changeLanguage'])->name('change-language'); // router change ngôn ngữ

    // Permission Module
    Route::get('/role-permission', [RolePermission::class, 'index'])->name('role.permission.list');
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

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
    Route::get('/show-data-table_machine', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_machine'])->name('update.show.data,machine');


    Route::get('/data-checklist-master', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_checklist_master'])->name('update.data.checklist.master');
    Route::get('/show-data-table-checklist-master', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_checklist_master'])->name('update.show.data.checklist.master');

    Route::get('/data-checklist-item', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_checklist_item'])->name('update.data.checklist.item');
    Route::get('/show-data-table-checklist-item', [\App\Http\Controllers\checklist\UpdateDataController::class, 'show_data_table_checklist_item'])->name('update.show.data.checklist.item');
    Route::get('/data-checklist-item_search', [\App\Http\Controllers\checklist\UpdateDataController::class, 'data_item_master'])->name('update.data.item_check');




    Route::get('/show-model', [DataTableController::class, 'show'])->name('update.show.model');
    Route::post('/edit-table/{model}', [DataTableController::class, 'edit_table'])->name('update.edit.data');
    Route::get('/show-data-table', [UpdatedataController::class, 'show_data_table'])->name('update.show.data');
    Route::post('/delete-data-table', [UpdatedataController::class, 'delete_data_row_table'])->name('update.delete.data');
    Route::post('/add-data-table', [UpdatedataController::class, 'add_data_row_table'])->name('update.add.data');
});



// Route WareHouse

Route::middleware('auth')->prefix('WareHouse')->group(function () {

    Route::get('/Nhap-kho', [HomeWareHouseController::class, 'index_nhap_kho'])->name('WareHouse.nhap.kho');
    Route::get('/show-master', [WarehouseController::class, 'show_master'])->name('WareHouse.show.master');
    Route::get('/search-master', [WarehouseController::class, 'search_master'])->name('WareHouse.show.product.infor');

    Route::post('/import', [WarehouseController::class, 'importStock'])->name('warehouse.import');

    Route::get('/Xuat-kho', [HomeWareHouseController::class, 'index_xuat_kho'])->name('WareHouse.xuat.kho');
    Route::post('/export', [WarehouseController::class, 'exportStock'])->name('warehouse.export');

    Route::get('/Chuyen-kho', [HomeWareHouseController::class, 'index_chuyen_kho'])->name('WareHouse.chuyen.kho');
    Route::post('/transfer', [WarehouseController::class, 'transferStock'])->name('warehouse.transfer');

    Route::get('/stock', [WarehouseController::class, 'showStock'])->name('warehouse.stock');
    Route::get('/Master', [HomeWareHouseController::class, 'index_master'])->name('WareHouse.update.master');
    Route::get('/User', [HomeWareHouseController::class, 'index_user'])->name('user.checklist');
});

Route::prefix('WareHouse/Master')->group(function () {

    Route::get('/data-sanpham', [UpdateDataWarehouseController::class, 'data_sanpham'])->name('Warehouse.update.data.sanpham');
    Route::get('/data-kho', [UpdateDataWarehouseController::class, 'data_kho'])->name('Warehouse.update.data.kho');
    Route::get('/data-model', [UpdateDataWarehouseController::class, 'data_model'])->name('Warehouse.update.data.model');
    Route::post('/upload-csv', [UpdateDataWarehouseController::class, 'update_table'])->name('Warehouse.table.update.data');



    Route::get('/show-data-table_machine', [UpdateDataWarehouseController::class, 'show_data_table_machine'])->name('update.show.data,machine');

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
