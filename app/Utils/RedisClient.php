<?php

namespace App\Utils;

use Illuminate\Support\Facades\Redis;

class RedisClient
{
    public function __construct()
    {
        Redis::select(config('R.REDIS_DATABASE'));
    }

    public static function set($key, $value, $expire = null)
    {
        Redis::set($key, $value);

        if (!is_null($expire)) {
            Redis::expire($key, $expire);
        }
    }

    public static function get($key)
    {
        return Redis::get($key);
    }

    public static function isExists($key)
    {
        return Redis::exists($key);
    }

    public static function selectDatabase($database = null)
    {
        if (is_null($database)) {
            Redis::select(config('R.REDIS_DATABASE'));
        } else {
            Redis::select($database);
        }
    }
}
