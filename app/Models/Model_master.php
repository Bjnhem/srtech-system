<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_master extends Model
{
    use HasFactory;
    protected $table = 'model';
    public $timestamps = true;
    protected $guarded = [];
}
