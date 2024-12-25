<?php

namespace App\Models\WareHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    protected $table = 'transfer_history';
    protected $fillable = ['product_id', 'warehouse_id', 'user','type', 'quantity','quantity_sumary', 'target_warehouse_id', 'Remark'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // public function targetWarehouse()
    // {
    //     return $this->belongsTo(Warehouse::class, 'target_warehouse_id');
    // }
}
