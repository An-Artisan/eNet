<?php

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected  $table = 'goods';

    protected $fillable = [
        'id', 'goods_title', 'goods_desc','goods_price', 'goods_original_price','goods_type_id',
        'goods_supplier_id','goods_photo','goods_is_publish'
    ];
}
