<?php

namespace App\Models\WareHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'warehouse_id', 'type', 'quantity', 'target_warehouse_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function targetWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'target_warehouse_id');
    }
}
