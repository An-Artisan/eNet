<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_id' => 'required|array',
            'single_price' => 'required|array',
            'sum_price' => 'required|integer',
            'count' => 'required|array',
            'use_red_packet' => 'required|integer',
            'red_packet_price' => 'integer',
            'red_packet_id' => "integer",
            'real_pay_price' => 'required|integer',
            'pay_way' => 'required|integer',
            'pay_status' => 'required|integer',
            'distribution_id' => 'required|integer',
            'transport_id' => 'required|integer',
        ];
    }
}
