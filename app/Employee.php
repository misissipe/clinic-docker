<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticableModel;


class Employee extends Model
{
    use Authenticatable;
    protected $connection = 'mysql';
    protected $table = 'employee_info';
    protected $fillable = [
        'id',
        'AgencyNumber', 
        'EmploymentStatus',
        'DepartmentName', 
        'LastName',
        'FirstName', 
        'MiddleName',
        'Sex',
        'DateOfBirth',
        'CivilStatus',
        'Citizenship',
        'RBarangay',
        'citymunDesc',
        'provDesc',
        'Cellphone',
        'EmailAddress',
        'campus',
    ];
}