<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measure extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'unit_of_measurement';
    protected $fillable = [
        'id', 
        'campus', 
        'created_by',
    ];
}
