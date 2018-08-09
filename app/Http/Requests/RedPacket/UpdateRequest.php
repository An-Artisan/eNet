<?php

namespace App\Http\Requests\RedPacket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        return $user->can('red-packet');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'red_packet_name' => 'required|string',
            'red_packet_price' => 'required|integer',
            'is_red_packet_threshold' => 'required|integer',
            'red_packet_threshold_price' => 'required|integer',
            'is_publish' => 'required|integer',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ];
    }
}
