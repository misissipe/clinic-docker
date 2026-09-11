<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticableModel;

class Treatment extends Model
{

    use Authenticatable;
    protected $connection = 'mysql';
    protected $table = 'treatmentrecord';
    protected $fillable = [
        'id',
        'patientId',
        'role',
        'gender',
        'age',
        'diagnosis',
        'treatment',
        'remarks',
        'stat',
        'ORnumber',
        'date',
        'campus'
    ];
}
