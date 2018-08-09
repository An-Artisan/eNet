<?php
namespace App\Utils;

class SendSMS {


    /**
     * Desc:
    $result=sendsmscode('要接收的手机号码');
    if($result==0)
    {
    echo "发送成功！";
    }
     * Date: 2018/8/7 0007
     * Time: 上午 9:19
     * @param $phone
     * @param $code
     * @return mixed
     * Created by StubbornGrass.
     */
    public static  function sendSMSCode($phone,$code)
    {
        $statusStr = ["0" => "短信发送成功", "-1" => "参数不全", "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！", "30" => "密码错误", "40" => "账号不存在", "41" => "余额不足", "42" => "帐户已过期", "43" => "IP地址限制", "50" => "内容含有敏感词"];

        $smsapi = "http://www.smsbao.com/"; //短信网关
        $user = "xinpinhui"; //短信平台帐号
        $pass = md5("xph123456"); //短信平台密码
        $content = "尊敬的用户，您的验证码是" . $code . "，请于10分钟内正确输入。如非本人操作，请忽略此短信。";//要发送的短信内容
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);
        return $result;
    }

}