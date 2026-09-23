<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateClinicNotifications extends Migration
{
    public function up()
    {
        Schema::create('clinic_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_key')->unique();
            $table->string('campus');
            $table->string('role');
            $table->string('message');
            $table->string('path');
            $table->timestamp('created_at');
            $table->index(['campus', 'role']);
        });
        Schema::create('clinic_notification_reads', function (Blueprint $table) {
            $table->unsignedBigInteger('notification_id');
            $table->string('reader', 64);
            $table->timestamp('read_at');
            $table->primary(['notification_id', 'reader']);
            $table->foreign('notification_id')->references('id')->on('clinic_notifications')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('clinic_notification_reads');
        Schema::dropIfExists('clinic_notifications');
    }
}
