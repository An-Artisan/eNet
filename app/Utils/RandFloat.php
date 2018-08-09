<?php

namespace App\Utils;

class RandFloat
{

    /**
     * Desc: 生成区间内的浮点数随机值
     * Date: 2018/7/5
     * Time: 17:39
     * @param $max
     * @param $min
     * @return float|int
     * Created by StubbornGrass.
     */
    public static function randFloat($max, $min)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
