<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Utils\Random;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RBAC\Role;
use App\Models\RBAC\Permission;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleResourceWithPermissionsAndUsers;
use App\Http\Requests\Api\Role\Index as IndexRole;
use App\Http\Requests\Api\Role\Show as ShowRole;
use App\Http\Requests\Api\Role\Store as StoreRole;
use App\Http\Requests\Api\Role\Update as UpdateRole;
use App\Http\Requests\Api\Role\Destroy as DestroyRole;
use App\Http\Requests\Api\Role\UpdatePermissions;
use App\Http\Requests\Api\Role\UpdateUsers;
use App\User;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RoleController extends Controller
{
    /**
     * 角色-全部
     * @param  Request
     * @return [type]
     * @author StubbornGrass
     */
    public function index(IndexRole $request)
    {
        $page = $request->input('page');
        if (!$page) {
            $data['data']['data'] = RoleResource::collection(Role::get());

        } else {
            $data['data']['data'] = RoleResource::collection(Role::paginate());
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-查看
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function show(ShowRole $request, $id)
    {
        $role = Role::findOrFail($id);
        $data['data']['data'] = new RoleResource($role);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-添加
     * @param  Request
     * @return [type]
     * @author StubbornGrass
     */
    public function store(StoreRole $request)
    {
        $data['data']['data'] = null;
        $data['status'] = config('R.SUCCESS');
        if ($role = Role::create($request->all())) {
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
        } else {
            $data['data']['code'] = config('R.FAIL');
            $data['data']['message'] = config('M.ADD_FAIL_MSG');
        }
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-更新
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function update(UpdateRole $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only(['display_name', 'description']));
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-删除
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function destroy(DestroyRole $request, $id)
    {
        Role::findOrFail($id)->delete();
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-同步权限
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function syncPermissions(UpdatePermissions $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->permissions;

        // 同步的权限为空时，解除当前角色的所有权限
        if (count(array_filter($permissions)) == 0) {
            $permissions = null;
        }

        $role->perms()->sync($permissions);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-添加权限
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function attachPermissions(UpdatePermissions $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = array_column($role->perms->all(), 'id');
        $role->perms()->sync(array_merge($permissions, $request->permissions));
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-同步用户
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function syncUsers(UpdateUsers $request, $id)
    {
        $role = Role::findOrFail($id);
        $users = $request->users;

        // 同步的用户为空时，解除当前角色的所有用户
        if (count(array_filter($users)) == 0) {
            $users = null;
        }
        // 删除同步用户的之前的角色
        User::find($users)->each(function ($user) {
                $user->roles()->sync([]);
        });
        $role->users()->sync($users);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-添加用户
     * @param  Request
     * @param  [type]
     * @return [type]
     * @author StubbornGrass
     */
    public function attachUsers(UpdateUsers $request, $id)
    {
        $role = Role::findOrFail($id);
        $oldUsers = array_column($role->users->all(), 'id');
        $users = $request->users;

        if ($role->name == config('R.MARKET')) {
            self::generateMarketInfo($request->users);
        }
        // 删除添加用户的之前的角色
        User::find($users)->each(function ($user) {
            $user->roles()->sync([]);
        });

        $role->users()->sync(array_merge($oldUsers, $request->users));
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }

    /**
     * 角色-权限
     * @param  IndexRole $request [description]
     * @param  [type]    $id      [description]
     * @return [type]             [description]
     */
    public function permissions(IndexRole $request, $id)
    {
        // 该角色未包含的权限
        if ($request->is_noexistent) {
            $ids = Role::find($id)->perms()->pluck('id');
            $data['data']['data']  =  PermissionResource::collection(Permission::whereNotIn('id', $ids)->get());
        } else {
            $data['data']['data']  =  PermissionResource::collection(Role::find($id)->perms()->get());
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));

    }
    
    /**
     * 角色-用户
     * @param  IndexRole $request [description]
     * @param  [type]    $id      [description]
     * @return [type]             [description]
     */
    public function users(IndexRole $request, $id)
    {
        $data['data']['data'] = UserResource::collection(Role::find($id)->users()->paginate());
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (response()->json($data['data'],$data['status']));
    }


    protected  function generateMarketInfo($useres) {
        foreach ($useres as $id) {
            $invate_code = Random::getRandom(config("R.INVATE_CODE_LENGTH"));
            $address = self::generateQrcode($invate_code,$invate_code . ".png");
            $user = User::find($id);
            $user->qrcode_address = $address;
            $user->invate_code = $invate_code;
            $user->update();
        }
    }

    protected function generateQrcode($code,$filename) {

        $path = "Qrcode" . DIRECTORY_SEPARATOR . $filename;
        $registerAddr =config("app.url") . "/register/" . $code;
        $logoAddr = '/public/Qrcode/logo.png';
        QrCode::format('png')->size(300)->merge($logoAddr,.30)->generate($registerAddr ,public_path() . DIRECTORY_SEPARATOR.  $path);
        return config("app.url") . DIRECTORY_SEPARATOR .$path;
    }
}
