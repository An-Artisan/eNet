<?php
namespace App\Http\Controllers\API\Account;

use App\Http\Requests\Account\AccountLoginRequest;
use App\Http\Requests\Account\AccountRegisterRequest;
use App\Http\Requests\Account\AccountUserDetails;
use App\Http\Requests\Account\AccountUserList;
use App\Http\Requests\Market\IndexRequest;
use App\Interfaces\UserInterface;
use App\Utils\InitiateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\RBAC\Role;
use Illuminate\Support\InteractsWithTime;
use Illuminate\Support\Traits\Macroable;

class AccountController extends Controller
{
    const TYPE_PLAYER = 'user'; // 玩家
    const TYPE_MANAGER = 'manager'; // 管理

    protected $inter;

    /**
     * 依赖注入
     * AccountController constructor.
     * @param UserInterface $inter
     */
    public function __construct(UserInterface $inter)
    {
        $this->inter = $inter;
    }


    /**
     * Desc: 退出登录
     * Date: 2018/6/20
     * Time: 16:17
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */
    public function logout(Request $request)
    {

        $result = $this->inter->logout($request);


        return response()->json($result->data, $result->status);
    }
    /**
     * 获取登录TOKEN
     * @param AccountLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AccountLoginRequest $request)
    {

        $result = $this->inter->login($request);

        return response()->json($result->data, $result->status);
    }

    /**
     * Desc: 注册用户
     * Date: 2018/6/20
     * Time: 16:17
     * @param AccountRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */
    public function register(AccountRegisterRequest $request)
    {
        $result = $this->inter->register($request);


        return response()->json($result->data, $result->status);
    }


    /**
     * Desc: 获取个人信息
     * Date: 2018/7/31 0031
     * Time: 下午 1:26
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */
    public function  getMeInfo(Request $request) {

        $data['status'] = config('R.SUCCESS');
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['data']['data'] = ($request->user());
        return response()->json($data['data'],$data['status']);
    }

    /**
     * Desc: 获取用户列表
     * Date: 2018/7/31 0031
     * Time: 下午 1:50
     * @param AccountUserList $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */
    public function getUserList(AccountUserList $request) {

        $result = $this->inter->getUserList($request);

        return response()->json($result->data, $result->status);
    }

    public function getMarketList(IndexRequest $request) {

        $result = $this->inter->getMarketList($request);

        return response()->json($result->data, $result->status);

    }

    /**
     * Desc: 根据userid获取用户详情
     * Date: 2018/7/31 0031
     * Time: 下午 1:50
     * @param AccountUserDetails $request
     * @return \Illuminate\Http\JsonResponse
     * Created by StubbornGrass.
     */
    public function getUserDetail(AccountUserDetails $request) {

        $result = $this->inter->getUserDetail($request);

        return response()->json($result->data, $result->status);
    }

    public function updatePhone(Request $request) {
        $result = $this->inter->updatePhone($request);

        return response()->json($result->data, $result->status);
    }
    public function updatePassword(Request $request) {
        $result = $this->inter->updatePassword($request);

        return response()->json($result->data, $result->status);
    }


}
