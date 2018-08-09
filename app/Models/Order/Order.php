<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $table = 'order';

    protected $fillable = [
        'id', 'order_number', 'userid',"goods_id","single_price","sum_price",
        "count","use_red_packet","distribution_fee","red_packet_price","real_pay_price",
        "pay_way","pay_status","distribution_id","order_status"
    ];
}
