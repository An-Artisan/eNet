<?php

namespace App\Models\RedPacket;

use Illuminate\Database\Eloquent\Model;

class RedPacket extends Model
{
    protected  $table = 'red_packet';

    protected $fillable = [
        'id', 'red_packet_name', 'red_packet_price','is_red_packet_threshold', 'goods_original_price','goods_type_id',
        'red_packet_threshold_price','is_publish','start_at','end_at'
    ];
}
