<?php

namespace App\Utils;

use Illuminate\Support\Facades\Artisan;

class Config
{

    /**
     * Desc: 更新env配置文件
     * Date: 2018/7/5
     * Time: 17:31
     * @param array $data
     * Created by StubbornGrass.
     */
    public function modifyEnv(array $data)
    {
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

        $contentArray->transform(function ($item) use ($data) {
            foreach ($data as $key => $value) {
                if (str_contains($item, $key)) {
                    return $key . '=' . $value;
                }
            }

            return $item;
        });

        $content = implode($contentArray->toArray(), "\n");

        \File::put($envPath, $content);
    }

    public function __destruct()
    {
        Artisan::call('config:cache');
    }
}
