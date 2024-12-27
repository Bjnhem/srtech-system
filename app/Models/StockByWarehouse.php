<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockByWarehouse extends Model
{
    // Định nghĩa tên bảng
    protected $table = 'stock_by_warehouse'; 

    // Các trường có thể được gán bằng cách sử dụng Eloquent
    protected $fillable = ['warehouse_id', 'location', 'status', 'stock_quantity', 'warehouse_name'];

    // Định nghĩa các mối quan hệ nếu có (nếu bạn có các liên kết giữa các bảng)
}
