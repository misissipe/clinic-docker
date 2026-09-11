<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessPeriodToAccountTable extends Migration
{
    public function up()
    {
        Schema::table('account', function (Blueprint $table) {
            $table->date('access_start')->nullable()->after('role');
            $table->date('access_end')->nullable()->after('access_start');
        });
    }

    public function down()
    {
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn(['access_start', 'access_end']);
        });
    }
}
