<?php

namespace App\Models\OQC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorList extends Model
{
    use HasFactory;
    protected $table = 'errors_list';
    protected $fillable = ['category',  'name'];
}
