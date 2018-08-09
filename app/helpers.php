<?php

use App\Models\SystemConfig;

/**
 * 翻译参数检验的提示消息
 * @author zhonghai.du
 */
if (! function_exists('translate_validation_messages')) {
    function translate_validation_messages($lang_file, $validations)
    {
        $func = function ($value) use ($lang_file) {
            return __($lang_file.'.'.$value);
        };

        $values = array_values($validations);
        return array_combine($values, array_map($func, $values));
    }
}

/**
 * 返回带消息的响应
 * @author zhonghai.du
 */
if (! function_exists('response_with_message')) {
    function response_with_message($message, $status_code)
    {
        return response(['message' => $message], $status_code);
    }
}

/**
 * 返回带数据的响应
 * @author zhonghai.du
 */
if (! function_exists('response_with_data')) {
    function response_with_data($data)
    {
        return response(['data' => $data]);
    }
}


/**
 * 返回带数据错误信息的响应
 * @author zhonghai.du
 */
if (! function_exists('response_with_data_errors')) {
    function response_with_data_errors($errors)
    {
        return response(['errors' => $errors], 422);
    }
}

/**
 * 读取系统配置
 */
if (! function_exists('get_system_config')) {
    function get_system_config($name)
    {
        $config = SystemConfig::where(
            [
                'name' => $name
            ]
        )->first();
        return  $config->value ?? null;
    }
}

/**
 * 配置系统配置
 */
if (! function_exists('set_system_config')) {
    function set_system_config($name, $value)
    {
        return SystemConfig::where(
            [
                'name' => $name
            ]
        )
        ->update(
            [
                'value' => $value
            ]
        );
    }
}
