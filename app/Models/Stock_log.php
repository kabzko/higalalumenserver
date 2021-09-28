<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'siorNo', 'supplierName', 'productId', 'cost', 'newAdded'
    ];
}
