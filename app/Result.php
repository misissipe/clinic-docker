<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'referral';

    protected $fillable = [
        'id', 'status', 'patientId',
    ];
}
