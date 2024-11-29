<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineLossesSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_losses_summary', function (Blueprint $table) {
            $table->id();
            $table->string('model'); // Tên Model (vd: S928)
            $table->string('item'); // Loại dữ liệu (vd: Prod, Q'ty NG, Rate)
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('week')->nullable();
            $table->date('date')->nullable();
            $table->integer('value')->nullable(); // Giá trị tương ứng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_losses_summary');
    }
}
