<?php

namespace App\Http\Controllers;

use App\Models\Goods\Goods;
use App\Models\RedPacket\UserRedPacket;
use App\Models\Transport\Transport;
use App\User;
use App\Utils\Random;
use App\Utils\WechatCallBackAPI;
use App\Utils\WechatLogin;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TomLingham\Searchy\Facades\Searchy;

class TestController extends Controller
{

    public function test(Request $request) {
        $loginParam['openid'] = 123;
        $loginParam['password'] = config('R.DEFAULT_PASSWORD');
       dd([
           'form_params' => config('passport') + $loginParam
       ]);

    }

    public function test2(Request $request) {

        $code = ($request->input('code'));
        $login = new WechatLogin("http://e5b9bbf5.ngrok.io/enet/enet/public/index.php/test2");
        $userinfo = $login->getWeChatUserInfo($code);
        $openid = $userinfo->openid;
        $nickname = $userinfo->nickname;
        $sex = $userinfo->sex;
        $sex = $userinfo->headimgurl;
    }

    public function login(Request $request) {

        $login = new WechatLogin("http://e5b9bbf5.ngrok.io/enet/enet/public/index.php/test2");

        $login->getCode();

//        dd($resu);
    }
}
