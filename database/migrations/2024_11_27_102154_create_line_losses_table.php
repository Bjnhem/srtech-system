<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineLossesTable extends Migration
{
    public function up()
    {
        Schema::create('line_losses', function (Blueprint $table) {
            $table->id(); // ID cho mỗi dòng loss
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade'); // Kết nối với bảng plans
            $table->foreignId('error_list_id')->constrained('errors_list')->onDelete('cascade'); // Kết nối với bảng errors_list
            $table->string('loss_type'); // Loại lỗi (ví dụ: thiếu nguyên liệu, lỗi máy móc)
            $table->text('remark'); // Ghi chú thêm về lỗi
            $table->integer('loss_amount'); // Số lượng mất mát
            $table->string('time_slot'); // Khung giờ
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('line_losses');
    }
}

