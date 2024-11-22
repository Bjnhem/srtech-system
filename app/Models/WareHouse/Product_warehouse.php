<?php

namespace App\Models\WareHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_warehouse extends Model
{

    use HasFactory;

    // Bảng tương ứng trong database
    protected $table = 'product_warehouse';

    // Các trường có thể được fill
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'type',
        'quantity',
        'Remark',
        'target_warehouse_id'
    ];

    /**
     * Quan hệ với bảng Product (một lịch sử thuộc về một sản phẩm)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Quan hệ với bảng Warehouse (một lịch sử thuộc về một kho)
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function targetWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'target_warehouse_id');
    }
}
