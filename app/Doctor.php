<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'doctors';
    protected $fillable = [
        'id',
        'campus',
        'license',
        'LastName',
        'FirstName',
        'MiddleName',
        'specialization',
        'created_by',
    ];

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class, 'doctor_id');
    }
}
