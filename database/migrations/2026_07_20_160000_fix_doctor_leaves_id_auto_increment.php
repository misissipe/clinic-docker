<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixDoctorLeavesIdAutoIncrement extends Migration
{
    public function up()
    {
        if (Schema::hasTable('doctor_leaves')) {
            DB::statement('ALTER TABLE doctor_leaves MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    public function down()
    {
        // Keep generated identifiers intact if this migration is rolled back.
    }
}
