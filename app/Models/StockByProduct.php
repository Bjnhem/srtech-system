<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockByProduct extends Model
{
    protected $table = 'stock_by_product'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['product_id', 'type', 'stock_quantity', 'warehouse_id', 'warehouse_name', 'name']; // Các trường dữ liệu có thể mass-assign
}
