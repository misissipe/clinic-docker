<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhenToTakeToDoctorConsultationTable extends Migration
{
    public function up()
    {
        Schema::table('doctor_consultation', function (Blueprint $table) {
            $table->string('when_to_take', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::table('doctor_consultation', function (Blueprint $table) {
            $table->dropColumn('when_to_take');
        });
    }
}
