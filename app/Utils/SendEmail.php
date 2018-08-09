<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/6/20
 * Time: 10:30
 */

namespace App\Utils;

use Illuminate\Support\Facades\Mail;

class SendEmail
{
    /**
     * Desc: 发送邮件
     * Date: 2018/7/5
     * Time: 17:40
     * @param $code
     * @param $to
     * @param $subject
     * Created by StubbornGrass.
     */
    public static function send($code, $to, $subject)
    {
        $data = array('code'=>$code);

        Mail::send('email.email', $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
}
