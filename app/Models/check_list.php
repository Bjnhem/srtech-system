<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class check_list extends Model
{
    use HasFactory;
    protected $table = 'checklist';
    public $timestamps = true;
    protected $guarded = [];
}
