<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    
    protected $table = 'student_info';
    protected $fillable = [
        'id', 
        'StudentNo', 
        'LastName',
        'FirstName',
        'MiddleName', 
        'Sex',
        'BirthDate',
        'courses',
        'accro',
        'major',
        'StudentYear',
        'ContactNo',
        'civil_status',
        'nationality',
        'religion',
        'brgy',
        'city',
        'province',
        'FatherName',
        'MotherName',
        'f_occupation',
        'm_occupation',
        'f_officeadd',
        'm_officeadd',
        'EC_name',
        'EC_contactNo',
        'EC_brgy',
        'EC_city',
        'EC_province',
        'campus',
        'StudentStatus'
    ];
}