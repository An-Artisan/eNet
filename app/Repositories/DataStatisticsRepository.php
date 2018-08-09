<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Interfaces\DataStatisticsInterface;
use App\Models\Goods\Goods;
use App\Models\Order\Order;
use App\Services\API;
use Illuminate\Http\Request;


class DataStatisticsRepository implements DataStatisticsInterface
{

    public function index (Request $request)
    {
        $start_at = $request->input('start_at');
        $end_at = $request->input('end_at');
        if (!is_null($start_at) && !is_null($end_at))
            $order = Order::where("created_at",">=",$start_at)
                ->where("created_at","<=",$end_at)
                ->get();
        else
            $order = Order::get();

        $sellPrice = 0;
        $originPrice = 0;
        foreach ($order as $item) {
            $sellPrice += $item->real_pay_price;
            $goods = json_decode($item->goods_id);
            $count = json_decode($item->count);
            for ($i = 0; $i < count($goods);$i ++)
            {
                $originPrice += Goods::find($goods[$i])->goods_original_price * ($count[$i]);
            }
        }

        $param['originPrice'] = $originPrice;
        $param['sellPrice'] = $sellPrice;
        $param['profit'] = $sellPrice - $originPrice;
        $data['data']['data'] = $param;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

}
