<?php

namespace App\Models\OQC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = ['date',  'shift', 'line', 'model', 'prod', 'a', 'b', 'c', 'd', 'e'];
}
