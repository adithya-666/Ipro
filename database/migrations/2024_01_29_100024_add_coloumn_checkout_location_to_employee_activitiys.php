<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnCheckoutLocationToEmployeeActivitiys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_activitys', function (Blueprint $table) {
            $table->string('checkout_location')->nullable(true)->after('checkout');
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
