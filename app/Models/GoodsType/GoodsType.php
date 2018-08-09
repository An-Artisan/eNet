<?php

namespace App\Models\GoodsType;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    protected  $table = 'goods_type';

    protected $fillable = [
        'id', 'goods_type_name', 'goods_type_desc','goods_type_leaset',
    ];
}
