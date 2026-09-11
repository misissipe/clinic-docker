<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalScheduleToAppointmentTable extends Migration
{
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->date('original_date')->nullable()->after('time');
            $table->time('original_time')->nullable()->after('original_date');
        });
    }

    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn(['original_date', 'original_time']);
        });
    }
}
