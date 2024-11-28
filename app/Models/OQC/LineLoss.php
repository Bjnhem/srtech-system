<?php

namespace App\Models\OQC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineLoss extends Model
{

    use HasFactory;

    // Định nghĩa tên bảng (nếu không theo chuẩn Laravel)
    protected $table = 'line_losses';
    public $timestamps = false;  // Nếu bạn không sử dụng `created_at` và `updated_at`, bạn có thể tắt timestamps

    // Định nghĩa các trường có thể gán đại trà
    protected $fillable = [
        'plan_id',
        'error_list_id',
        'Code_ID',
        'remark',
        'NG_qty',
        'time_slot',
        'prod_qty',
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
