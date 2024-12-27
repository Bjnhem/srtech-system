<?php

// Controllers

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WareHouse\HomeWareHouseController;
use App\Http\Controllers\WareHouse\UpdateDataWarehouseController;
use App\Http\Controllers\WareHouse\WarehouseController;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

// Route WareHouse

// Route::middleware('role')->prefix('WareHouse')->group(function () {
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeWareHouseController::class, 'index_nhap_xuat'])->name('Home.index');
});

Route::middleware('role')->prefix('nhap-xuat')->group(function () {
    // Route nhập xuất
    Route::get('/', [HomeWareHouseController::class, 'index_nhap_xuat'])->name('WareHouse.chuyen.kho');
    Route::get('/get-products-transfer', [WarehouseController::class, 'get_search'])->name('get_search');
    Route::get('/get-warehouse-transfer', [WarehouseController::class, 'get_warehouse'])->name('get_warehouse');
    Route::post('/nhap-xuat', [WarehouseController::class, 'history_transfer'])->name('warehouse.transfer');

    // Route nhập xuất excel
    Route::get('/nhap-xuat-excel', [HomeWareHouseController::class, 'index_nhap_xuat_excel'])->name('WareHouse.chuyen.kho.excel');


    // Route::get('/show-master-transfer', [WarehouseController::class, 'show_master_transfer'])->name('WareHouse.show.master.transfer');
    // Route::get('/api/get-status', [WarehouseController::class, 'get_status'])->name('get_status');
});



Route::middleware('role')->prefix('stock')->group(function () {
    // Route tồn kho
    Route::get('/', [HomeWareHouseController::class, 'index_ton_kho'])->name('warehouse.stock');
    Route::get('/get-type', [WarehouseController::class, 'get_type_stock'])->name('warehouse.get.type');
    Route::get('/get-products', [WarehouseController::class, 'get_stock_product_search'])->name('warehouse.get.product');
    Route::get('/get-warehouse', [WarehouseController::class, 'get_stock_warehouse_search'])->name('warehouse.get.warehouse');

    Route::get('/stock-data-detail', [WarehouseController::class, 'getStock_by_detail'])->name('warehouse.stock.data.by.detail');
    Route::get('/stock-data-product', [WarehouseController::class, 'getStock_by_product'])->name('warehouse.stock.data.by.product');
    Route::get('/stock-data-warehouse', [WarehouseController::class, 'getStock_by_warehouse'])->name('warehouse.stock.data.by.warehouse');
});


Route::middleware('role')->prefix('history')->group(function () {
    // Route history
    Route::get('/', [HomeWareHouseController::class, 'index_history'])->name('WareHouse.history');
    Route::get('/get-type', [WarehouseController::class, 'get_type_history'])->name('warehouse.get.type.history');
    Route::get('/get-products', [WarehouseController::class, 'get_product_history'])->name('warehouse.get.product.history');
    Route::get('/get-warehouse', [WarehouseController::class, 'get_warehouse_history'])->name('warehouse.get.warehouse.history');
    Route::get('/data-history', [WarehouseController::class, 'show_data_history'])->name('warehouse.data.history');
});





Route::middleware('role:admin,leader')->prefix('Master')->group(function () {

    Route::get('/', [HomeWareHouseController::class, 'index_master'])->name('WareHouse.update.master');
    Route::get('/data-sanpham', [UpdateDataWarehouseController::class, 'data_sanpham'])->name('Warehouse.update.data.sanpham');
    Route::get('/data-kho', [UpdateDataWarehouseController::class, 'data_kho'])->name('Warehouse.update.data.kho');
    Route::get('/data-model', [UpdateDataWarehouseController::class, 'data_model'])->name('Warehouse.update.data.model');
    Route::post('/upload-csv', [UpdateDataWarehouseController::class, 'update_table'])->name('Warehouse.table.update.data');
    Route::post('/upload-kho-item', [UpdateDataWarehouseController::class, 'updateFromExcel_kho'])->name('warehouse.update.kho');
    Route::post('/upload-product-item', [UpdateDataWarehouseController::class, 'updateFromExcel_product'])->name('warehouse.update.product');

    Route::get('/model-masster', [UpdateDataWarehouseController::class, 'check_list_masster'])->name('model.masster');  // show model search
    Route::get('/show-data-table-product', [UpdateDataWarehouseController::class, 'showData'])->name('Warehouse.update.show.data.product');
    Route::post('/product/save', [UpdateDataWarehouseController::class, 'store_products'])->name('product.save');
    Route::get('/show-data-table', [UpdateDataWarehouseController::class, 'show_data_table'])->name('Warehouse.update.show.data');
    Route::post('/add-data-table', [UpdateDataWarehouseController::class, 'add_data_row_table'])->name('Warehouse.update.add.data');
    Route::post('/delete-data-table', [UpdateDataWarehouseController::class, 'delete_data_row_table'])->name('Warehouse.update.delete.data');

    // Route upload data excel
    Route::get('/download-template/{file_name}', [UpdateDataWarehouseController::class, 'downloadTemplate'])->name('warehouse.download.template');
});



// route User
Route::middleware('role:admin,leader')->prefix('User')->group(function () {

    Route::get('/', [UserController::class, 'index_user'])->name('user.index');
    Route::get('/show-data-table', [UserController::class, 'show_data_table'])->name('User.update.show.data');
    Route::post('/add-data-table', [UserController::class, 'add_data_row_table'])->name('User.update.add.data');
    Route::post('/delete-data-table', [UserController::class, 'delete_data_row_table'])->name('User.delete.data');
    Route::get('/pending-users', [WarehouseController::class, 'getPendingUsers'])->name('show.messing');
});


//Auth pages Routs
Route::group(['prefix' => '/'], function () {
    Route::get('login', [AuthController::class, 'signin'])->name('auth.signin');
    Route::POST('login', [AuthController::class, 'submit_login'])->name('auth.submit.signin');
    Route::get('register', [AuthController::class, 'signup'])->name('auth.signup');
    Route::POST('register', [AuthController::class, 'submit_register'])->name('auth.submit.signup');
    Route::POST('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/check-username', [AuthController::class, 'checkUsername'])->name('auth.check.username');
});
