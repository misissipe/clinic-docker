<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeHRMIS extends Model
{
    use SoftDeletes;
    protected $connection = 'hrmis';
    protected $table = 'employee';
}
