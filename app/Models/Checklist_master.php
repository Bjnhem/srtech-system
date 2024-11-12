<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_master extends Model
{
    use HasFactory;
    protected $table = 'checklist_master';
    public $timestamps = true;
    protected $guarded = [];

    public function machine()
    {
        return $this->belongsTo(Machine_master::class, 'Machine', 'Machine');
    }
}
