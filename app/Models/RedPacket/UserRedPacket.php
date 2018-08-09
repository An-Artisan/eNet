<?php

namespace App\Models\RedPacket;

use Illuminate\Database\Eloquent\Model;

class UserRedPacket extends Model
{
    protected  $table = 'user_red_packet';

    protected $fillable = [
        'id', 'userid', 'red_packet_id'
    ];


    public function redPacket () {

        return $this->hasOne('App\Models\RedPacket\RedPacket', 'id', 'red_packet_id');
    }
}
