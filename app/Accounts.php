<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthenticableModel;

class Accounts extends AuthenticableModel

{
    use SoftDeletes, Authenticatable;
    protected $table = "users";
    protected $fillable = [
        'email',
        'role',
        'campus',
        'password'
    ];

}
