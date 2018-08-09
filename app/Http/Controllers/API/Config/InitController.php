<?php

namespace App\Http\Controllers\API\Config;

use App\Models\RBAC\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InitController extends Controller
{


    /**
     * Desc: 自动更新权限列表
     * Date: 2018/7/5
     * Time: 17:23
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */

    public function initPermission(Request $request)
    {
        $token = $request->input("token");

        if ($token != 'adminInit') {
            $data['data'] = ["message" => config('M.FAIL_MSG')];
            $data['status'] = config('R.SUCCESS');
            $result =  (object) $data;
            return response()->json($result->data, $result->stats);
        }
        $path = database_path() .DIRECTORY_SEPARATOR . 'datas' . DIRECTORY_SEPARATOR . 'permissions.json';
        $data =  json_decode(\File::get($path), false);
        $permission = new Permission();

        foreach ($data as $value) {
            $isExist = $permission->where("name", $value->name)->first();
            if ($isExist) {
                $isExist->display_name = $value->display_name;
                $isExist->description = $value->description;
                $isExist->update();
            } else {
                Permission::insert(["name" => $value->name,"display_name" => $value->display_name,
                    "description" => $value->description,"created_at" => date('Y-m-d H:i:s', time()),
                    "updated_at" => date('Y-m-d H:i:s', time())]);
            }
        }
        $data['data'] = ["message" => config('M.SUCCESS_MSG')];
        $data['status'] = config('R.SUCCESS');
        $result =  (object) $data;
        return response()->json($result->data, $result->status);
    }
}
