<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nhan_vien_check_list extends Model
{
    use HasFactory;
    protected $table = 'nhan_vien_check_list';
    public $timestamps = true;
    protected $guarded = [];
}
