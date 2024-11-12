<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class line extends Model
{
    use HasFactory;
    protected $table = 'line_master';
    public $timestamps = true;
    protected $guarded = [];
}
