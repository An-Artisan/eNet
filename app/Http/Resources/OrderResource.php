<?php

namespace App\Http\Resources;

use App\Models\Distribution\Distribution;
use App\Services\API;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'userid' => $this->userid,
            'goods_id' => json_decode($this->goods_id),
            'single_price' => json_decode($this->single_price),
            'sum_price' => $this->sum_price,
            'count' => json_decode($this->count),
            'use_red_packet' => $this->use_red_packet ? "使用红包" : "未使用红包",
            'distribution_fee' => $this->distribution_fee,
            'red_packet_price' => $this->red_packet_price,
            'real_pay_price' => $this->real_pay_price,
            'pay_way' => $this->pay_way ? "在线支付" : "货到付款",
            'pay_status' => self::getPayStatus($this->pay_status),
            'distribution_way' => ($distributionWay = API::getAtributeForId($this->distribution_id,"distribution_title",Distribution::class)) ? $distributionWay : "无配送方式",
            'order_status' => self::getOrderStatus($this->order_status),
            'created_at' => $this->updated_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    protected  function getPayStatus($status) {
        switch ($status) {
            case 0:
                return "未支付";
            case 1:
                return "已经支付";
            case 2:
                return "货到付款";
            case 3:
                return "订单失效";
        }

    }
    protected  function getOrderStatus($status) {
        switch ($status) {
            case 0:
                return "待收货";
            case 1:
                return "已发货";
            case 2:
                return "收获成功";
        }

    }
}
