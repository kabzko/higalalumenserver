<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_batch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'batchNum', 'stockId', 'productId', 'price', 'quantity'
    ];
}
