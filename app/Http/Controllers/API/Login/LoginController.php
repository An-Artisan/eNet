<?php

namespace App\Http\Controllers\API\Login;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\API;
use App\User;
use App\Utils\WechatCallBackAPI;
use App\Utils\WechatLogin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends  Controller {

    public function  valid() {

        $wechatObj = new WechatCallBackAPI();

        $wechatObj->valid();
    }

    public function login(Request $request) {

        $code = $request->input("code");
        if (!is_null($code)) {
            Cache::forever("code", $code);
        }
        $login = new WechatLogin(config('R.WECHAT_REDIRECT'));

        $login->getCode();
    }

    public function getCode(Request $request) {

        $code = ($request->input('code'));
        $login = new WechatLogin(config('R.WECHAT_REDIRECT'));
        $userinfo = $login->getWeChatUserInfo($code);
        $param['openid'] = $userinfo->openid;
        $param['nickname'] = $userinfo->nickname;
        $param['sex'] = $userinfo->sex;
        $param['photo'] = $userinfo->headimgurl;
        if (!User::where("openid",$param['openid'])->first()) {
            Cache::forever("info",json_encode($param));
            $invaidCode = Cache::pull('code');
            echo "<script>location.href='".config("R.REDIRECT_REGISTER"). "?code=" . $invaidCode . "'</script>";
        } else
        {
            $loginParam['username'] = $param['openid'];
            $loginParam['password'] = config('R.DEFAULT_PASSWORD');
            $client = new Client();
            $request = $client->request('POST', request()->root() . '/oauth/token', [
                'form_params' => config('passport') + $loginParam
            ]);
            $token = json_decode($request->getBody()->getContents(), true);
            Cache::forever("token",$token);
            echo "<script>location.href='".config("R.HOME_PAGE") ."'</script>";
        }

    }

    public function  getToken(Request $request) {
        $openid = Cache::pull('token');
        $data['data']['data'] = ($openid);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return response()->json($data['data'], $data['status']);
    }

    public function getInfo(Request $request) {
        $openid = Cache::pull('info');
        $data['data']['data'] = json_decode($openid);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return response()->json($data['data'], $data['status']);
    }
}