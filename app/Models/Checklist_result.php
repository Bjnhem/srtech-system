<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_result extends Model
{
    use HasFactory;
    protected $table = 'checklist_result';
    public $timestamps = true;
    protected $guarded = [];
}
