<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine_master extends Model
{
    use HasFactory;
    protected $table = 'machine_master';
    public $timestamps = true;
    protected $guarded = [];

    public function checklists()
    {
        return $this->hasMany(Checklist_master::class, 'Machine', 'Machine');
    }
}
