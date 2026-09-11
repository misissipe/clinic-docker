<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medical extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'medicalrecord';
    protected $fillable = [
        'id',
        'patientId',
        'role',
        'positioncourse',
        'age',
        'gender',
        'findings',
        'parameters',
        'recommendation',
        'status',
        'purpose',
        'others',
        'OTCmedpcs',
        'OTCmedDescript',
        'weight',
        'height',
        'blood_type',
        'temp',
        'pulse',
        'res_rate',
        'bp',
        'campus',
        'date',
        'time',
    ];
}
