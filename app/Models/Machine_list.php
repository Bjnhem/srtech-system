<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine_list extends Model
{
    use HasFactory;
    protected $table = 'machine_list';
    public $timestamps = true;
    protected $guarded = [];
}
