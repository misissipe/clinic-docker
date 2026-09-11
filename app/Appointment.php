<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as AuthenticableModel;

class Appointment extends AuthenticableModel
{
    use SoftDeletes, Authenticatable;

    protected $table = 'appointment';

    protected $fillable = [
        'patientId',
        'contactNo',
        'lastname',
        'firstname',
        'middlename',
        'role',
        'date',
        'time',
        'original_date',
        'original_time',
        'purpose',
        'status',
        'remarks',
        'campus',
        'approve_at',
        'disapprove_at',
        'reschedule_at',
    ];

    protected $casts = [
        'purpose' => 'array',
        'date' => 'date',
        'original_date' => 'date',
        'approve_at' => 'datetime',
        'disapprove_at' => 'datetime',
        'reschedule_at' => 'datetime',
    ];
}
