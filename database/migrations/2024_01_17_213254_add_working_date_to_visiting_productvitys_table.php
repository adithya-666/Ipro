<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkingDateToVisitingProductvitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visiting_productivitys', function (Blueprint $table) {
            $table->dateTime('working_date')->nullable()->after('schedule');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visiting_productivitys', function (Blueprint $table) {
            //
        });
    }
}
