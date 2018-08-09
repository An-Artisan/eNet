<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;

class GoodsResource extends JsonResource
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
            'goods_title' => $this->goods_title,
            'goods_desc' => $this->goods_desc,
            'goods_price' => $this->goods_price,
            'goods_original_price' => $this->goods_original_price,
            'goods_type_id' => $this->goods_type_id,
            'goods_supplier_id' => $this->goods_supplier_id,
            'goods_photo' => $this->goods_photo,
            'goods_is_publish' => $this->goods_is_publish,
            'goods_count' => $this->goods_count,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
