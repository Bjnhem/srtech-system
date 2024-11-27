<?php

namespace App\Models\OQC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineLoss extends Model
{

    use HasFactory;

    // Định nghĩa tên bảng (nếu không theo chuẩn Laravel)
    protected $table = 'line_losses';

    // Định nghĩa các trường có thể gán đại trà
    protected $fillable = [
        'plan_id',
        'error_list_id',
        'loss_type',
        'remark',
        'loss_amount',
        'time_slot',
    ];

    // Mối quan hệ với bảng plans
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Mối quan hệ với bảng errors_list
    public function errorList()
    {
        return $this->belongsTo(ErrorList::class, 'error_list_id');
    }
}
