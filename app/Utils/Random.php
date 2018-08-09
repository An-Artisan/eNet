<?php

namespace App\Utils;

use Illuminate\Support\Facades\Crypt;

class Random
{

    /**
     * Desc: 生成随机密码
     * Date: 2018/7/5
     * Time: 17:39
     * @param $max
     * @param $min
     * @return float|int
     * Created by StubbornGrass.
     */
    public static function getRandom($length = 8)
    {
        $str = substr(md5(time()), 0, $length);
        return $str;
    }
}
