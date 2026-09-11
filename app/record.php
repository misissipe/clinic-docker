<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    
    protected $table = 'medicalrecord';

    protected $fillable = [
        'StudentNo', 'findings', 'parameters', 'date',
    ];
}