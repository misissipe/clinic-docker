<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabResult extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'labresult';
    protected $fillable = [
        'id',
        'patientId',
        'role',
        'file_cbc',
        'file_urinalysis',
        'file_xray',
        'file_ecg',
        'file_drug_test',
        'file_others',
        'campus',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
