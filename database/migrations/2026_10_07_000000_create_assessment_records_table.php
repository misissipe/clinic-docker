<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('assessment_records', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id', 100)->index();
            $table->string('patient_name');
            $table->string('role', 50);
            $table->json('answers');
            $table->string('campus', 50)->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_records');
    }
}
