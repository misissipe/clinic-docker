<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoggedOutDateToMedicalrecordTable extends Migration
{
    public function up()
    {
        Schema::table('medicalrecord', function (Blueprint $table) {
            $table->date('logged_out_date')->nullable()->after('logged_out');
        });
    }

    public function down()
    {
        Schema::table('medicalrecord', function (Blueprint $table) {
            $table->dropColumn('logged_out_date');
        });
    }
}
