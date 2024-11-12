<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_item extends Model
{
    use HasFactory;
    protected $table = 'checklist_item';
    public $timestamps = true;
    protected $guarded = [];
}
