<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signatories extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'signatories';
    protected $fillable = [
        'id',
        'campus',
        'LastName',
        'FirstName',
        'MiddleName',
        'Role',
        'Designation',
        'Office',
        'services',
        'created_at',
        'deleted_at',
        'updated_at',
        
    ];
}
