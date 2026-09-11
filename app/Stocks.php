<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stocks extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'stock';
    protected $fillable = [
        'id',
        'item_name',
        'item_quantity',
        'measurement',
        'campus',
        'created_by',
    ];
}
