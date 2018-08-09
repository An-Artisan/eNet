<?php

namespace App\Http\Controllers\API\WechatPay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;

class WeChatPayController extends Controller
{
    protected $config = [
        'wechat' => [
            'app_id' => 'wxb3f6d0xxxxxxxd',
            'mch_id' => '1457768302',
            'notify_url' => 'http://yansongda.cn/wechat_notify.php',
            'key' => 'mF2suE9sU6Mkxxxxxxx5645645',
            'cert_client' => './apiclient_cert.pem',
            'cert_key' => './apiclient_key.pem',
        ],
    ];

    public function index()
    {
        $order = [
            'out_trade_no' => time(),
            'body' => 'subject-测试',
            'total_fee' => '1',
            'openid' => 'onkVf1FjWS5SBxxxxxxxx',
        ];
        $result = Pay::wechat($this->config)->mp($order);
        dd($result);
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);
        $verify = $pay->driver('wechat')->gateway('mp')->verify($request->getContent());

        if ($verify) {
            file_put_contents('notify.txt', "收到来自微信的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $verify['out_trade_no'] . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $verify['total_fee'] . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}