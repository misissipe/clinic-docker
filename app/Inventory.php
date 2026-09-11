<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{

    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'inventory';
    protected $fillable = [
        'id',
        'stockId',
        'item_quantity',
        'item_stock',
        'stock_less',
        'remaining_stock',
        'created_by',
    ];
}
