<?php

namespace App\Models\WareHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sku', 'description', 'price', 'ID_SP', 'Code_Purchase', 'Model', 'Type', 'Image', 'Part_ID'];

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
