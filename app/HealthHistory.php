<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class HealthHistory extends Model
{
    
    protected $table = 'health_history';
    protected $connection = 'mysql';
    protected $fillable = [
        'campus',
        'role',
        'patientId',
        'family_his',
        'othersFamhis',
        'personal_his',
        'sticksPerDay',
        'forYears',
        'shot',
        'beer',
        'shotPer',
        'beerPer',
        'past_illness',
        'present_illness',
        'othersPreIll',
        'hospitalization',
        'hos_detail',
        'medicine_mnt',
        'med_detail',
        'allergies',
        'al_detail',
        'immunization_his',
        'othersImmu'
    ];
}