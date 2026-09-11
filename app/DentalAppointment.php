<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalAppointment extends Model
{
    protected $fillable = [
        'user_id',
        'patient_type',
        'patient_id',
        'full_name',
        'course_department',
        'contact_number',
        'services',
        'appointment_date',
        'appointment_time',
        'reason_for_visit',
        'additional_notes',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'services' => 'array',
    ];
}