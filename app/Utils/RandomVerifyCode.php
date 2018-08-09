<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/6/19
 * Time: 20:42
 */

namespace App\Utils;

class RandomVerifyCode
{

    /**
     * Desc: 生成指定长度的随机验证码
     * Date: 2018/7/5
     * Time: 17:40
     * @param $length
     * @param null $chars
     * @return string
     * Created by StubbornGrass.
     */
    public static function produceVerifyCode($length, $chars = null)
    {
        if (is_null($chars)) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }
}
