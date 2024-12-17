<?php

namespace App\Models\WareHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'sku', 'description', 'stock_limit', 'ID_SP', 'Code_Purchase', 'Model', 'Type', 'Image', 'Part_ID'];

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    public function stockMovements()
    {
        return $this->hasMany(\App\Models\WareHouse\StockMovement::class, 'product_id', 'id');
    }
}
