<?php

// Controllers

use App\Http\Controllers\admin_check_list_controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DataTbaleController;
use App\Http\Controllers\AdminController as ControllersAdminController;
use App\Http\Controllers\check_list_controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Plan_checklist;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\UserController;
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

Route::prefix('check-list')->group(function () {
    Route::get('show/{line}', [check_list_controller::class, 'index_checklist_show'])->name('show.checklist');
    Route::get('/checklist-masster', [check_list_controller::class, 'check_list_masster'])->name('check.list.masster');  // show model search
    Route::get('/item-check', [check_list_controller::class, 'Machine_ID_search'])->name('item.checklist.search');  // show model search
    Route::get('/khung-gio-check', [check_list_controller::class, 'Khung_check'])->name('khung.check.search');  // show model search

    Route::post('/Check-Machine-ID', [check_list_controller::class, 'Check_machine_ID'])->name('check.machine');




    Route::post('/check-list-overview', [check_list_controller::class, 'search_check_list_overview'])->name('check.list.overview');  // show model search
    Route::delete('/checklist/{id}', [check_list_controller::class, 'delete_check_list'])->name('delete.check.list');


    Route::get('/check-list-show', [check_list_controller::class, 'check_list_detail'])->name('check.list.search');  // show model search
    Route::get('/check-list-edit', [check_list_controller::class, 'check_list_edit_detail'])->name('check.list.edit.search');  // show model search
    Route::post('/save-check-list/{table}', [check_list_controller::class, 'save_check_list'])->name('save.check.list');  // show model search
    Route::post('/save-check-list-detail/{table}', [check_list_controller::class, 'save_check_list_detail'])->name('save.check.list.detail');  // show model search
    Route::post('/update-check-list-detail/{table}', [check_list_controller::class, 'update_check_list_detail'])->name('update.check.list.detail');  // show model search
    Route::post('/search-check-list', [check_list_controller::class, 'search_check_list'])->name('search.check.list');  // show model search
    Route::post('/search-check-list-view', [check_list_controller::class, 'search_check_list_view'])->name('search.check.list.view');  // show model search
    Route::post('/edit-table/{model}', [check_list_controller::class, 'edit_table'])->name('check.list.edit.data');
    Route::post('/edit-check-list', [check_list_controller::class, 'save_edit_check_list'])->name('save.edit.check.list');  // show model search
    Route::get('/delete-check-list', [check_list_controller::class, 'delete_row'])->name('check.list.delete');
});

Route::prefix('Plan-checklist')->group(function () {
    Route::get('', [Plan_checklist::class, 'index_plan'])->name('Plan.checklist');
    Route::post('/add-plan', [Plan_checklist::class, 'created_plan_checklist'])->name('add.plan.checklist');
    Route::post('/delete-plan', [Plan_checklist::class, 'delete_plan_checklist'])->name('delete.plan.checklist');
    Route::post('/show-plan', [Plan_checklist::class, 'show_plan_checklist'])->name('show.plan.checklist');
    Route::post('/check-list-plan', [check_list_controller::class, 'search_check_list_overview'])->name('check.list.overview');  // show model search 
    Route::get('/api/events', [Plan_checklist::class, 'show_plan'])->name('show.plan');
 

});

Route::prefix('Update-master')->group(function () {
        Route::get('/data-checklist', [UpdatedataController::class, 'data_checklist'])->name('update.data.checklist');
        Route::get('/data-line', [UpdatedataController::class, 'data_line'])->name('update.data.line');
   
});


Route::group(['middleware' => 'auth'], function () {
    //router home
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/checklist-overview', [HomeController::class, 'overview_data'])->name('checklist.overview');
    Route::get('/checklist', [HomeController::class, 'index_checklist'])->name('Check.checklist');
    // Route::get('Update-master', [HomeController::class, 'index_master'])->name('Master.checklist');
    Route::get('/User', [HomeController::class, 'index_user'])->name('user.checklist');
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

/* update data table */
Route::/* middleware('auth')-> */prefix('admin-dashboard')->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('admin.index');
    Route::get('check-list', [AdminController::class, 'index_check_list'])->name('admin.checklist');
    Route::get('check-list-search', [AdminController::class, 'index_search'])->name('admin.checklist.search');
    Route::get('check-list-edit', [AdminController::class, 'index_edit'])->name('admin.checklist.edit');
    Route::get('check-list-pending', [AdminController::class, 'index_pending'])->name('admin.checklist.pending');
    Route::get('historry', [AdminController::class, 'index_historry'])->name('admin.checklist.historry');
    Route::post('/add-plan-checklist', [admin_check_list_controller::class, 'created_plan_checklist'])->name('admin.add.plan.checklist');
});

Route::/* middleware('auth')-> */prefix('admin-dashboard/check-list')->group(function () {

    Route::get('/check-list', [admin_check_list_controller::class, 'check_list_search'])->name('admin.show.check.list');  // show model search
    Route::get('/line-type', [admin_check_list_controller::class, 'line_type_search'])->name('admin.line.type.search');  // show model search
    Route::get('/cong_doan', [admin_check_list_controller::class, 'cong_doan_search'])->name('admin.cong.doan.search');  // show model search
    Route::get('/phan-loai', [admin_check_list_controller::class, 'phan_loai_search'])->name('admin.phan.loai.search');  // show model search
    Route::get('/check-list-show', [admin_check_list_controller::class, 'check_list_detail'])->name('admin.check.list.search');  // show model search
    Route::get('/check-list-show-overview', [admin_check_list_controller::class, 'check_list_detail_overview'])->name('admin.check.list.search.overview');  // show model search

    Route::post('/save-check-list-pending/{table}', [admin_check_list_controller::class, 'save_check_list_pending'])->name('admin.save.check.list.pending');  // show model search
    Route::post('/save-check-list-historry-pad', [admin_check_list_controller::class, 'save_check_list_historry_pad'])->name('admin.save.check.list.historry.pad');  // show model search

    Route::get('/check-list-show-edit', [admin_check_list_controller::class, 'check_list_detail_edit'])->name('admin.check.list.search.edit');  // show model search
    Route::post('/save-check-list/{table}', [admin_check_list_controller::class, 'save_check_list'])->name('admin.save.check.list');  // show model search
    Route::post('/save-check-list-historry', [admin_check_list_controller::class, 'save_check_list_historry'])->name('admin.save.check.list.historry');  // show model search
    Route::post('/save-check-list-detail/{table}', [admin_check_list_controller::class, 'save_check_list_detail'])->name('admin.save.check.list.detail');  // show model search
    Route::post('/search-check-list', [admin_check_list_controller::class, 'search_check_list'])->name('admin.search.check.list');  // show model search
    Route::post('/search-check-list-view', [admin_check_list_controller::class, 'search_check_list_view'])->name('admin.search.check.list.view');  // show model search
    Route::post('/search-check-list-overview', [admin_check_list_controller::class, 'search_check_list_overview'])->name('admin.search.check.list.overview');  // show model search

    Route::post('/edit-table/{model}', [admin_check_list_controller::class, 'edit_table'])->name('admin.check.list.edit.data');
    Route::post('/edit-check-list', [admin_check_list_controller::class, 'save_edit_check_list'])->name('admin.save.edit.check.list');  // show model search


    Route::get('/delete-check-list', [admin_check_list_controller::class, 'delete_row_search'])->name('admin.check.list.delete');
    Route::get('/delete-check-list-edit', [admin_check_list_controller::class, 'delete_row_edit'])->name('admin.check.list.delete.edit');
    Route::get('/new-row', [admin_check_list_controller::class, 'new_row'])->name('admin.check.list.new_row');
});

Route::/* middleware('auth')-> */prefix('admin-dashboard/check-list-overview')->group(function () {

    /* Route::get('/check-list', [admin_check_list_controller::class, 'check_list_search'])->name('admin.show.check.list');  // show model search
    Route::get('/line-type', [admin_check_list_controller::class, 'line_type_search'])->name('admin.line.type.search');  // show model search
    Route::get('/cong_doan', [admin_check_list_controller::class, 'cong_doan_search'])->name('admin.cong.doan.search');  // show model search
    Route::get('/phan-loai', [admin_check_list_controller::class, 'phan_loai_search'])->name('admin.phan.loai.search');  // show model search
    Route::get('/check-list-show', [admin_check_list_controller::class, 'check_list_detail'])->name('admin.check.list.search');  // show model search


    Route::get('/check-list-show-edit', [admin_check_list_controller::class, 'check_list_detail_edit'])->name('admin.check.list.search.edit');  // show model search
    Route::post('/save-check-list', [admin_check_list_controller::class, 'save_check_list'])->name('admin.save.check.list');  // show model search
    Route::post('/save-check-list-detail', [admin_check_list_controller::class, 'save_check_list_detail'])->name('admin.save.check.list.detail');  // show model search
    Route::post('/search-check-list', [admin_check_list_controller::class, 'search_check_list'])->name('admin.search.check.list');  // show model search
    Route::post('/search-check-list-view', [admin_check_list_controller::class, 'search_check_list_view'])->name('admin.search.check.list.view');  // show model search
   
    Route::post('/edit-table/{model}', [admin_check_list_controller::class, 'edit_table'])->name('admin.check.list.edit.data');
    Route::post('/edit-check-list', [admin_check_list_controller::class, 'save_edit_check_list'])->name('admin.save.edit.check.list');  // show model search
  

    Route::get('/delete-check-list', [admin_check_list_controller::class, 'delete_row_search'])->name('admin.check.list.delete');
    Route::get('/delete-check-list-edit', [admin_check_list_controller::class, 'delete_row_edit'])->name('admin.check.list.delete.edit');
    Route::get('/new-row', [admin_check_list_controller::class, 'new_row'])->name('admin.check.list.new_row'); */
});


/* update data table */
Route::/* middleware('auth')-> */prefix('admin-dashboard/update-data')->group(function () {
    Route::get('', [DataTbaleController::class, 'index'])->name('table.index');
    Route::get('/show/{table}', [DataTbaleController::class, 'table_show'])->name('table.show');
    Route::get('/show-model', [DataTbaleController::class, 'show'])->name('table.show.model');
    Route::get('/list', [DataTbaleController::class, 'list'])->name('table.list');
    Route::post('/upload-csv', [DataTbaleController::class, 'update_table'])->name('table.update.data');
    Route::post('/edit-table/{model}', [DataTbaleController::class, 'edit_table'])->name('table.edit.data');
    Route::get('/new-row', [DataTbaleController::class, 'new_row'])->name('table.new_row');
    Route::get('/delete-row', [DataTbaleController::class, 'delete_row'])->name('table.delete_row');
});


Route::/* middleware('auth')-> */prefix('admin-dashboard/master')->group(function () {
    Route::get('', [master_data_controller::class, 'index'])->name('master.index');
    Route::get('/show/{table}', [master_data_controller::class, 'table_show'])->name('master.show');
    Route::get('/add-check-list-name', [master_data_controller::class, 'add_check_list_name'])->name('master.add.check.list.name');

    Route::get('/show-model', [master_data_controller::class, 'show'])->name('master.show.model');
    Route::get('/list', [master_data_controller::class, 'list'])->name('master.list');
    Route::post('/upload-csv', [master_data_controller::class, 'update_table'])->name('master.update.data');
    Route::post('/edit-table/{model}', [master_data_controller::class, 'edit_table'])->name('master.edit.data');
    Route::get('/new-row', [master_data_controller::class, 'new_row'])->name('master.new_row');
    Route::get('/delete-row', [master_data_controller::class, 'delete_row'])->name('master.delete_row');
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
