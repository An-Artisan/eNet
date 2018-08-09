<?php

namespace App\Http\Controllers\API\Config;

use App\Http\Requests\Config\GetDefaultValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Config\SetDefaultValue;
use App\Models\SMSCode\SMSCode;
use App\Services\API;
use App\Utils\Random;
use App\Utils\SendSMS;
use App\Utils\Upload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{


    /**
     * Desc: 设置系统默认值
     * Date: 2018/8/3
     * Time: 17:21
     * @param SetDefaultValue $request
     * @return \Illuminate\Http\JsonResponse|object
     * Created by StubbornGrass.
     */
    public function setDefaultValue(SetDefaultValue $request)
    {
        $defaultKey = $request->input('default_key');
        $defaultValue = $request->input('default_value');

        $key = config('R.' . $defaultKey);

        if (!$key) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.ERROR');
            $data['data']['message'] = config('M.PARAM_ERROR_MSG');
            $data['status'] = config('R.SUCCESS');
            return response()->json($data['data'], $data['status']->status);

        }

        Cache::forever(config('R.' . $defaultKey), $defaultValue);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        $result = (object)$data;
        return response()->json($result->data, $result->status);
    }

    /**
     * Desc: 获取系统默认值
     * Date: 2018/7/5
     * Time: 17:21
     * @param GetDefaultValue $request
     * @return \Illuminate\Http\JsonResponse|object
     * Created by StubbornGrass.
     */
    public function getDefaultValue(GetDefaultValue $request)
    {
        $defaultKey = $request->input('default_key');
        $key = config('R.' . $defaultKey);

        if (!$key) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.ERROR');
            $data['data']['message'] = config('M.PARAM_ERROR_MSG');
            $data['status'] = config('R.SUCCESS');
            $result = (object)$data;
            return response()->json($result->data, $result->status);
        }
        if ($defaultKey == 'UPLOAD_SIZE_KEY') {
            $data['data']['data'] = ini_get("upload_max_filesize");
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
            $data['status'] = config('R.SUCCESS');
            $result = (object)$data;
            return response()->json($result->data, $result->status);
        }
        $exist = Cache::has(config('R.' . $defaultKey));
        if ($exist) {
            $defaultValue = Cache::get(config('R.' . $defaultKey));
            $data['data']['data'] = $defaultValue;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
            $data['status'] = config('R.SUCCESS');
        } else {
            $data['data']['data'] = config('R.' . $defaultKey . '_VALUE');
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
            $data['status'] = config('R.SUCCESS');
        }
        $result = (object)$data;
        return response()->json($result->data, $result->status);
    }

    public function uploadGoodsImage(\Illuminate\Http\Request $request) {

        $typePath = $request->input('path');
        $path = public_path() . DIRECTORY_SEPARATOR .$typePath . DIRECTORY_SEPARATOR;
        $imagePath = $typePath . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path,0777);
        }
        $data['status'] = config('R.SUCCESS');

        if ($_FILES['image']['error'] !== 4) {
            // 返回值的地址赋值给cover
            $cover = Upload::uploadImage($_FILES,$path,$imagePath,'image');
            $imagePath =   DIRECTORY_SEPARATOR . $cover;
            $data['data']['data'] = ["domain" => config("app.url") ,"imagePath" => $imagePath];
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
        }
        $result = (object) $data;
        return response()->json($result->data, $result->status);
    }

    public function sendSMSCode(Request $request) {
        $phone = $request->input("phone");
        $code = Random::getRandom(4);
        $result = SendSMS::sendSMSCode($phone,$code);
        if ($result == 0) {
            $param['phone'] = $phone;
            $param['code'] = $code;
            API::createModel($param,SMSCode::class);
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
            $data['status'] = config('R.SUCCESS');
        }
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SEND_CODE_FAIL_MSG');
        return (object)$data;
    }


}
