<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;

class UserResource extends JsonResource
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
            'name' => $this->username,
            'nickname' => $this->nickname,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'email' => $this->email,
            'role'  => $this->roles,
            'sex'  => $this->sex,
            'is_phone'  => $this->is_phone,
            'qrcode_address'=> $this->qrcode_address,
            'invate_code'   => $this->invate_code,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
