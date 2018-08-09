<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class InitiateRequest
{
    protected $client = null;

    /**
     * 初始化登录，获取cookie
     * InitiateRequest constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['cookies' => true,'timeout'  => config('R.TIME_OUT')]);
        $this->client->request(
            'POST',
            config('R.GOLD777_LOGIN_WITH_POST'),
            ['form_params' => ['j_username' => config('R.GOLD777_J_USERNAME'), 'j_password' => config('R.GOLD777_J_PASSWORD')]
            ,['connect_timeout' => config('R.TIME_OUT')]]
        );
    }

    /**
     * Desc: 公用请求
     * Date: 2018/7/5
     * Time: 17:32
     * @param $url
     * @param $param
     * @param $method
     * @return bool|string
     * Created by StubbornGrass.
     */
    public function request($url, $param, $method, $headers = null)
    {
        if ($method == 'GET' || $method == 'get') {
            $url .= '?';
            foreach ($param as $item => $value) {
                $url .= $item . '=' . $value . '&';
            }
            $url = substr($url, 0, strlen($url) - 1);
        }

        try {
            if ($method == 'get' || $method == 'GET') {
                if ($headers) {
                    $res = $this->client->request($method, $url, ["headers" => $headers]);
                } else {
                    $res = $this->client->request($method, $url);
                }
            } else {
                $res = $this->client->request($method, $url, ['form_params' => $param]);
            }
        } catch (RequestException $e) {
            return false;
        }

        $content = $res->getBody()->getContents();

        return $content;
    }

    /**
     * Desc: 更新密码
     * Date: 2018/7/5
     * Time: 17:32
     * @param $username
     * @param $password
     * @return bool
     * Created by StubbornGrass.
     */
    public function updatePassword($username, $password)
    {
        $result = $this->request(config('R.GOLD777_UPDATE_USER_PASSWORD_WITH_GET'), ["newpwd" => $password, "nickname" => "", "accname" => $username, "setType" => "player"], 'GET');
        if (strpos($result, 'password:ok') !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Desc: eth 转换美元
     * Date: 2018/7/16
     * Time: 20:52
     * @param $url
     * @param $param
     * @param $method
     * @param $headers
     * @return bool|string
     * Created by StubbornGrass.
     */
    public static function ethToUsd($url, $param, $method, $headers)
    {
        if ($method == 'GET' || $method == 'get') {
            $url .= '?';
            foreach ($param as $item => $value) {
                $url .= $item . '=' . $value . '&';
            }
            $url = substr($url, 0, strlen($url) - 1);
        }
        $client = new Client(['timeout'  => config('R.TIME_OUT')]);
        try {
            if ($method == 'get' || $method == 'GET') {
                if ($headers) {
                    $res = $client->request($method, $url, ["headers" => $headers]);
                } else {
                    $res = $client->request($method, $url);
                }
            } else {
                $res = $client->request($method, $url, ['form_params' => $param]);
            }
        } catch (RequestException $e) {
            return false;
        }

        $content = $res->getBody()->getContents();

        return $content;
    }

    /**
     * Desc: 以太坊公共请求
     * Date: 2018/7/16
     * Time: 20:52
     * @param $url
     * @param $param
     * @param $method
     * @return bool|mixed
     * Created by StubbornGrass.
     */
    public static function ethereum($url, $param, $method)
    {
        $client = new Client(['timeout'  => config('R.TIME_OUT')]);
        try {
            $res = $client->request($method, $url, ['form_params' => $param]);
        } catch (RequestException $e) {
            return false;
        }
        $content = $res->getBody()->getContents();

        return json_decode($content, false);
    }
}
