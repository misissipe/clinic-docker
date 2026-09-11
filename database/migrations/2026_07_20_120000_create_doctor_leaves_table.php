<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorLeavesTable extends Migration
{
    public function up()
    {
        Schema::create('doctor_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('doctor_id');
            $table->string('campus')->nullable()->index();
            $table->date('starts_on')->index();
            $table->date('ends_on')->index();
            $table->string('reason')->nullable();
            $table->string('announcement', 500)->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_leaves');
    }
}
