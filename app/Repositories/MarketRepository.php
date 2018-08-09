<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\GoodsTypeResource;
use App\Http\Resources\UserResource;
use App\Interfaces\GoodsTypeInterface;
use App\Interfaces\MarketInterface;
use App\Models\Order\Order;
use App\Services\API;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class MarketRepository implements MarketInterface
{

    public function show (Request $request,$id)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = UserResource::collection(User::where("parent_id",$id)->get());
        } else {
            $info = User::where("parent_id",$id)->paginate($limit);
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
    public function money (Request $request)
    {

        $start_at = $request->input('start_at');
        $end_at = $request->input('end_at');

        $userid = $request->input('userid');
        $users = User::where("parent_id",$userid)->get(["id"]);
        if (!$users->count()) {
            $data['data']['data'] = 0;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.SUCCESS_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        foreach ($users as $user) {
            $usersid[] = $user->id;
        }
        if (!is_null($start_at) && !is_null($end_at))
            $order = Order::where("created_at",">=",$start_at)
                ->where("created_at","<=",$end_at)
                ->whereIn("userid",$usersid)->get()->sum("real_pay_price");
        else
            $order = Order::whereIn("userid",$usersid)->get()->sum("real_pay_price");

        $exist = Cache::has(config('R.MARKET_MONEY_PERCENT'));
        if ($exist) {
            $percent = Cache::get(config('R.MARKET_MONEY_PERCENT'));
        } else {
            $percent = config('R.MARKET_MONEY_PERCENT_VALUE');
        }
        $data['data']['data'] = $order * $percent;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object)$data;
     }
}
