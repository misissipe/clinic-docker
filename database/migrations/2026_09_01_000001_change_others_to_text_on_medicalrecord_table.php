<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOthersToTextOnMedicalrecordTable extends Migration
{
    public function up()
    {
        Schema::table('medicalrecord', function (Blueprint $table) {
            $table->text('others')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('medicalrecord', function (Blueprint $table) {
            $table->string('others', 255)->nullable()->change();
        });
    }
}
