<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orderId', 'cashierName', 'name', 'price', 'quantity', 'vat', 'benefits', 'discounts', 'customerName', 'cash', 'type', 'status'
    ];
}
