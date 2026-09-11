<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'medicalcert';
    protected $fillable = [
        'status',
        'id',
        // add more fields as necessary
    ];
}
