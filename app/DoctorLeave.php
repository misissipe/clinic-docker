<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorLeave extends Model
{
    protected $table = 'doctor_leaves';

    protected $fillable = [
        'doctor_id',
        'campus',
        'starts_on',
        'ends_on',
        'reason',
        'announcement',
        'created_by',
    ];

    protected $casts = [
        'starts_on' => 'date',
        'ends_on' => 'date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
