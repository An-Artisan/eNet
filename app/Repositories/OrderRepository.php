<?php
/**
 * Created by PhpStorm.
 * User: StubbornGrass
 * Date: 2018/06/15
 * Time: 20:26
 */

namespace App\Repositories;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SupplierResource;
use App\Interfaces\OrderInterface;
use App\Models\Distribution\Distribution;
use App\Models\Goods\Goods;
use App\Models\Order\Order;
use App\Models\RedPacket\RedPacket;
use App\Services\API;
use App\Utils\Random;
use Illuminate\Http\Request;


class OrderRepository implements OrderInterface
{


    public function index (Request $request)
    {
        $limit = $request->input('limit');
        $page = $request->input('page');

        if (!$page) {
            $data['data']['data'] = OrderResource::collection(Order::get());
        } else {
            $info = Order::paginate($limit);
            $data['data']['data']['data'] = OrderResource::collection($info);
            $info = $info->toArray();
            unset($info['data']);
            $data['data']['data']['paginate'] = $info;
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function store (Request $request)
    {


        foreach ($request->input('goods_id') as $value) {
            if (!($price = API::getAtributeForId($value,'goods_price',Goods::class))) {
                $data['data']['data'] = null;
                $data['data']['code'] = config('R.SUCCESS');
                $data['data']['message'] = config('M.GOODS_EXIST_MSG');
                $data['status'] = config('R.SUCCESS');
                return (object) $data;
            }
            $goodsSinglePrice[] = $price;
        }
        if ($goodsSinglePrice != $request->input('single_price')) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.PRICE_ERROER_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        $sumPrice = 0;
        for($i = 0;$i < count($goodsSinglePrice);$i++) {
            $sumPrice += $goodsSinglePrice[$i] * $request->input("count")[$i];
        }
        if ($sumPrice != $request->input('sum_price')) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.PRICE_ERROER_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        $redPacket = 0;
        if ($request->input("use_red_packet") == config('R.USE_RED_PACKET')) {
            $redPacket = $request->input("red_packet_price");
            $redPacketId = $request->input("red_packet_id");
        }

        $redPacketModel = RedPacket::find($redPacketId);
        if ($redPacket && $sumPrice < $redPacketModel->red_packet_threshold_price) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.PRICE_ERROER_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        if ($redPacketModel->red_packet_price != $redPacket) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.PRICE_ERROER_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        $distrubutionId = $request->input('distribution_id');
        $distrubutionFee = API::getAtributeForId($distrubutionId,"distribution_fee",Distribution::class);
        if ($distrubutionId === false) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.DISTRIBUTION_EXIST_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        if (($sumPrice - $redPacket + $distrubutionFee) != $request->input('real_pay_price')) {
            $data['data']['data'] = null;
            $data['data']['code'] = config('R.SUCCESS');
            $data['data']['message'] = config('M.PRICE_ERROER_MSG');
            $data['status'] = config('R.SUCCESS');
            return (object) $data;
        }
        $param['order_number'] = Random::getRandom(config("R.ORDER_NUMBER_LENGTH"));
        $param['userid'] = $request->user()->id;
        $param["goods_id"] = json_encode($request->input("goods_id"));
        $param["single_price"] = json_encode($request->input("single_price"));
        $param["sum_price"] = $request->input("sum_price");
        $param["count"] = json_encode($request->input("count"));
        $param["use_red_packet"] = $request->input("use_red_packet");
        $param["red_packet_price"] = $request->input("red_packet_price");
        $param["real_pay_price"] = $request->input("real_pay_price");
        $param["red_packet_price"] = $redPacket;
        $param["pay_way"] = $request->input("pay_way");
        if ($request->input('pay_way') == config('R.UNDER_LINE_PAY')) {
            $orderStatus = config('R.ORDER_STATUS_DELIVERY');
        } else {
            $orderStatus = config('R.ORDER_STATUS_NOT_PAYMENT');
        }
        $param["pay_status"] = $request->input("pay_status");
        $param["distribution_id"] = $request->input("distribution_id");
        $param["transport_id"] = $request->input("transport_id");
        $param["order_status"] = $orderStatus;
        API::createModel($param,Order::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function update (Request $request,$id)
    {
        $param['order_status'] = $request->input('order_status');

        API::updateModel($id,$param,Order::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function destroy (Request $request,$id)
    {
        API::deteleModel($id,Order::class);
        $data['data']['data'] = null;
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function show (Request $request, $id)
    {
        $data['data']['data'] = OrderResource::collection(Order::find($id)->get());
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }

    public function getOrderWithUserid (Request $request, $userid)
    {
        $orderStatus = $request->input('order_status');
        $limit = $request->input('limit');
        $page = $request->input('page');
        if (!is_null($orderStatus)) {
            $order = Order::where("order_status",$orderStatus)->where("userid",$userid);
        } else {
            $order = Order::where("userid",$userid);
        }
        if (!$page) {
            $data['data']['data'] = OrderResource::collection($order->get());
        } else {
            $data['data']['data'] = OrderResource::collection($order->paginate($limit));
        }
        $data['data']['code'] = config('R.SUCCESS');
        $data['data']['message'] = config('M.SUCCESS_MSG');
        $data['status'] = config('R.SUCCESS');
        return (object) $data;
    }
}
