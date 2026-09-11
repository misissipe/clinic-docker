<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AllowMultipleCampusesPerAccount extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `account` DROP PRIMARY KEY, ADD PRIMARY KEY (`employee_id`, `campus`)');
    }

    public function down()
    {
        if (DB::table('account')->select('employee_id')->groupBy('employee_id')->havingRaw('COUNT(*) > 1')->exists()) {
            throw new RuntimeException('Cannot restore the single-column account key while employees have access to multiple campuses.');
        }

        DB::statement('ALTER TABLE `account` DROP PRIMARY KEY, ADD PRIMARY KEY (`employee_id`)');
    }
}
