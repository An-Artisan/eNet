<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\Order\Order;
use App\Models\RBAC\Role;
use App\Models\SMSCode\SMSCode;
use App\Services\API;
use App\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class UserRepository implements UserInterface
{


    /**
     * Desc: 用户登录获取token信息，支持用户名或者手机号作为登录名
     * Date: 2018/6/19
     * Time: 18:52
     * @param Request $request
     * @return object
     * Created by StubbornGrass.
     */
    public function login(Request $request)
    {

        $username = $request->get('username');
        $user = User::orWhere('phone', $username)->orWhere('username', $username)->orWhere('openid', $username)->first();
        if (!$user) {
            $data['status'] = config('R.SUCCESS');
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.ACCOUNT_NOT_EXIST_MSG');
            $data['data']['data'] = null;
            return (object) $data;
        }
        $client = new Client();
        try {
            $request = $client->request('POST', request()->root() . '/oauth/token', [
                'form_params' => config('passport') + $request->only(array_keys($request->rules()))
            ]);
            $data['data']['data'] = json_decode($request->getBody()->getContents(), true);
            unset($data['data']['data']['token_type']);
            $data['status'] = config('R.SUCCESS');
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
        } catch (RequestException $e) {
            $data['status'] = config('R.SUCCESS');
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.LOGIN_FAIL_MSG');
            $data['data']['data'] = null;

        }
        if ($user->roles[0]->name == 'admin' ) {
            self::orderAutoSuccess();
        }
        self::orderAutoExpire($user->id);
        return (object) $data;
    }
    /**
     * Desc: 用户退出登录
     * Date: 2018/6/19
     * Time: 9:46
     * @param Request $request
     * @return mixed
     * Created by StubbornGrass.
     */
    public function logout(Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }
        $data['status'] = config('R.SUCCESS');
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['data']['data'] = null;
        return (object) $data;
    }

    /**
     * Desc: 注册用户
     * Date: 2018/6/19
     * Time: 16:10
     * @param Request $request
     * @return object
     * Created by StubbornGrass.
     */
    public function register(Request $request)
    {
        $param['openid'] = $request->input('openid');
        $param['nickname'] = $request->input('nickname');
        $param['sex'] = $request->input('sex');
        $param['photo'] = $request->input('photo');
        $param['phone'] = $request->input('phone');
        $code  = $request->input('code');

        $param['invate_code'] = $request->input('invate_code');
        $param['password'] = bcrypt(config("R.DEFAULT_PASSWORD"));

        SMSCode::where("code",$code)->delete();
        $param['parent_id'] = User::where("invate_code",$param['invate_code'])->first()->id;
        $user = API::createModel($param,User::class);
        $role = Role::where("name",config('R.MARKET'))->first();
        $role->users()->sync([$user->id]);
        $loginParam['username'] = $param['openid'];
        $loginParam['password'] = config('R.DEFAULT_PASSWORD');
        $client = new Client();
        $request = $client->request('POST', request()->root() . '/oauth/token', [
            'form_params' => config('passport') + $loginParam
        ]);
        $token = json_decode($request->getBody()->getContents(), true);
        $data['data']['code'] = $token;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    /**
     * Desc: 获取用户列表
     * Date: 2018/7/31 0031
     * Time: 下午 1:33
     * @param Request $request
     * Created by StubbornGrass.
     */
    public function getUserList (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = UserResource::collection(User::get());

        } else {
            $info = User::paginate($limit);
            $data['data']['data']['data'] = UserResource::collection($info);
            $info = $info->toArray();
            unset($info['data']);
            $data['data']['data']['paginate'] = $info;
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    /**
     * Desc: 根据userid获取用户详情
     * Date: 2018/7/31 0031
     * Time: 下午 1:50
     * @param Request $request
     * @return object
     * Created by StubbornGrass.
     */
    public function getUserDetail(Request $request) {
        $id = $request->input('id');
        $user = User::find($id);
        $data['data']['data'] = new UserResource($user);
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object)$data;
    }

    public function getMarketList(Request $request) {

        $limit = $request->input('limit');
        $page = $request->input('page');
        if (!$page) {
            $data['data']['data'] = UserResource::collection(Role::where("name",config("R.MARKET"))->first()->users()->get());
        } else {
            $info = Role::where("name",config("R.MARKET"))->first()->users()->paginate($limit);
            $data['data']['data']['data'] = UserResource::collection($info);
            $info = $info->toArray();
            unset($info['data']);
            $data['data']['data']['paginate'] = $info;
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;

    }

    public function updatePhone(Request $request) {
        $code = $request->input('code');
        $oldPhone = $request->input('old_phone');
        $newPhone = $request->input('new_phone');

        $codeModel = SMSCode::where("code",$code)->where("phone",$oldPhone)->first();
        if (!$codeModel || ($codeModel->code != $code)) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.CODE_OR_PHONE_ERROR_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        User::where("phone",$oldPhone)->update(["phone"=>$newPhone]);
        $codeModel->delete();
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function updatePassword(Request $request) {
        $code = $request->input('code');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $codeModel = SMSCode::where("code",$code)->where("phone",$phone)->first();
        if (!$codeModel || ($codeModel->code != $code)) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.CODE_OR_PHONE_ERROR_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        User::where("phone",$phone)->update(["password"=>bcrypt($password)]);
        $codeModel->delete();
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }


    /**
     * Desc: 订单自动失效
     * Date: 2018/8/6 0006
     * Time: 下午 6:17
     * @param $userid
     * Created by StubbornGrass.
     */
    protected   function  orderAutoExpire($userid) {

        if (Cache::has(config("R.ORDER_AUTO_EXPIRE"))) {
            $autoExpireTime = Cache::get(config('R.ORDER_AUTO_EXPIRE'));
        }else {
            $autoExpireTime = config('R.ORDER_AUTO_EXPIRE_VALUE');
        }
        $endAt = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s",time())) - $autoExpireTime);
        Order::where("userid",$userid)
            ->where("created_at","<",$endAt)
            ->where("pay_status",config('R.NOT_PAY'))
            ->update(["pay_status"=>config('R.LOST_PAY')]);

    }

    /**
     * Desc: 订单自动收货成功
     * Date: 2018/8/6 0006
     * Time: 下午 6:22
     * Created by StubbornGrass.
     */
    protected function orderAutoSuccess() {

        if (Cache::has(config("R.ORDER_AUTO_SUCCESS"))) {
            $autoSuccessTime = Cache::get(config('R.ORDER_AUTO_SUCCESS'));
        }else {
            $autoSuccessTime = config('R.ORDER_AUTO_SUCCESS_VALUE');
        }
        $endAt = date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s",time())) - $autoSuccessTime);
        Order::where("created_at","<",$endAt)
            ->where("order_status",config('R.ORDER_STATUS_DISPATCHED'))
            ->update(["order_status"=>config('R.ORDER_STATUS_SUCCESS')]);
    }


}
