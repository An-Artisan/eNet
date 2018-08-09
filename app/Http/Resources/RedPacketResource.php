<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;

class RedPacketResource extends JsonResource
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
            'red_packet_name' => $this->red_packet_name,
            'red_packet_price' => $this->red_packet_price,
            'is_red_packet_threshold' => $this->is_red_packet_threshold,
            'red_packet_threshold_price' => $this->red_packet_threshold_price,
            'is_publish' => $this->is_publish,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
