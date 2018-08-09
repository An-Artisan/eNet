<?php

namespace App\Utils;

use Illuminate\Support\Facades\Cache;

class WechatLogin
{
    private $appId = 'wxfa0d9c8531840921';
    private $secret = '6874a5c68c2f68f7733c261678ae8b53';
    private $userOpenId;
    private $redirect_uri;

    /**
     * Undocumented function
     * 设置回掉地址
     */
    /**
     * WeChat constructor.
     * @param string $module 模块名称 因为有两个模块在微信上使用 默认就是用户端 wechat 其次为 clients  客户端的
     */
    public function __construct($url)
    {
        $this->redirect_uri = urlencode($url);
    }

    /**
     * Undocumented function
     * 用户授权获取Code.
     */
    public function getCode()
    {
//        snsapi_base
//        snsapi_userinfo
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=$this->redirect_uri&response_type=code&scope=snsapi_base&state=0#wechat_redirect";
        header("location:$url");
        exit();
    }

    /**
     * Undocumented function
     * 获取用户信息.
     *
     * @param [type] $code 用户授权的Code
     */
    public function getWeChatUserInfo($code)
    {
        //获取缓存中的accessToken有则拉缓存无则从新获取

        $accessToken = $this->getAccessToken($code);
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$accessToken&openid=$this->userOpenId&lang=zh_CN";
        $userInfo = json_decode($this->sendRequest($url));
        if (isset($userInfo->errcode) && '40003' == $userInfo->errcode) {
            throw new HttpException($userInfo->errmsg);
        } else {
            return $userInfo;
        }
    }

    /**
     * Undocumented function
     * 获取access_token.
     *
     * @param [type] $code 用户授权后获取的Code
     */
    public function getAccessToken($code)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->secret&code=$code&grant_type=authorization_code";
        $result = json_decode($this->sendRequest($url));
        $this->userOpenId = $result->openid;

        return $result->access_token;
    }

    /**
     * Undocumented function
     * curl请求
     *
     * @param [type] $url 请求地址
     */
    public function sendRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    /**
     * Undocumented function
     * 检查access_token 是否有效.
     */
    public function checkAccessToken()
    {
        $accessToken = Cache::get('weChatAccessToken');
        $url = "https://api.weixin.qq.com/sns/auth?access_token=$accessToken&openid=$this->userOpenId";
        $result = $this->sendRequest($url);
        dump($result);
    }
}
