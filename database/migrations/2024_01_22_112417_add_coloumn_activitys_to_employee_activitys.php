<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnActivitysToEmployeeActivitys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_activitys', function (Blueprint $table) {
            $table->unsignedBigInteger('visiting_productivity_id')->nullable(true)->after('employee_id');
            $table->foreign('visiting_productivity_id')->references('id')->on('visiting_productivitys');
            $table->dateTime('checkin_location')->nullable(true)->after('checkin');
            $table->string('location')->nullable(true)->after('checkin_location');
            $table->dateTime('maintenance')->nullable(true)->after('location');
            $table->dateTime('report_time')->nullable(true)->after('maintenance');
            $table->string('status')->nullable(true)->after('checkout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_activitys', function (Blueprint $table) {
            //
        });
    }
}
