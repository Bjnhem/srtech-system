<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master_check_list_line extends Model
{
    use HasFactory;
    protected $table = 'master_check_list_line';
    public $timestamps = true;
    protected $guarded = [];

    public function result_check_list()
    {
        return $this->hasMany(result_check_list::class, 'id_check_list_line');
    }
}
