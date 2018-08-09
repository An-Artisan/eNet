<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RBAC\Permission;
use App\Http\Requests\Api\Permission\Index as IndexPermission;
use App\Http\Requests\Api\Permission\Show as ShowPermission;
use App\Http\Requests\Api\Permission\Update as UpdatePermission;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionsWithRoleResource;

class PermissionController extends Controller
{
    /**
     * 权限-全部
     * @param  Request
     * @return [type]
     * @author zhonghai.du
     */
    public function index(IndexPermission $request)
    {
        if (!$request->page) {
            if ($request->include_role) {
                return PermissionsWithRoleResource::collection(Permission::get()->groupBy('group_name'));
            }
            $data['data']['data'] =  PermissionResource::collection(Permission::get());
        } else {
            $data['data']['data'] =  PermissionResource::collection(Permission::paginate());
        }

        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 权限-查看
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author zhonghai.du
     */
    public function show(ShowPermission $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $data['data']['data'] = new PermissionResource($permission);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
    * 权限-更新
    * @param  Request
    * @param  [type]
    * @return [type]
    * @author zhonghai.du
    */
    public function update(UpdatePermission $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->only(['display_name', 'description']));
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }
}
