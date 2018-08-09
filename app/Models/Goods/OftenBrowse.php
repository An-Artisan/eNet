<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Model;

class OftenBrowse extends Model
{
    protected  $table = 'often_browse';

    protected $fillable = [
        'id', 'userid', 'goods_id'
    ];

    public function oftenBrowse () {

        return $this->hasOne('App\Models\Goods\Goods', 'id', 'goods_id');
    }
}
