<?php

namespace App\Models\ShoppingCart;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected  $table = 'shoppingcart';

    protected $fillable = [
        'id', 'userid', 'userid','single_price','sum_price','count'
    ];
}
