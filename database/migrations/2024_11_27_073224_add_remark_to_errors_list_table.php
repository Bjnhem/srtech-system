<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarkToErrorsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('errors_list', function (Blueprint $table) {
            $table->string('remark')->nullable()->after('name'); // Thêm cột 'remark'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('errors_list', function (Blueprint $table) {
            $table->dropColumn('remark'); // Xóa cột 'remark' nếu rollback
        });
    }
}
