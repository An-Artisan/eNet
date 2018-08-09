<?php

namespace App\Models\GoodsType;

use Illuminate\Database\Eloquent\Model;

class GoodsTypeSecond extends Model
{
    protected  $table = 'goods_type_second';

    protected $fillable = [
        'id', 'goods_type_second_name', 'goods_type_second_desc','goods_type_id'
    ];

    public function goodsType () {

        return $this->hasOne('App\Models\GoodsType\GoodsType', 'id', 'goods_type_id');
    }
}
