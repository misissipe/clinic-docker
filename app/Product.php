<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'product';
    protected $fillable = [
        'id',
        'generic_name',
        'brand_name',
        'campus',
        'created_by',
    ];
}
