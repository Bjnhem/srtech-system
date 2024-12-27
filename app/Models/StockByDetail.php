<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockByDetail extends Model
{
    // Định nghĩa tên bảng
    protected $table = 'stock_by_detail'; 

    // Các trường có thể được gán bằng cách sử dụng Eloquent
    protected $fillable = ['product_id', 'warehouse_id', 'type', 'stock_quantity'];

    // Định nghĩa các mối quan hệ nếu có (nếu bạn có các liên kết giữa các bảng)
}
