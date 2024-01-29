<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_activity_id');
            $table->foreign('employee_activity_id')->references('id')->on('employee_activitys');
            $table->string('report')->nullable(true);
            $table->string('file')->nullable(true);
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
        Schema::dropIfExists('report_detail');
    }
}
