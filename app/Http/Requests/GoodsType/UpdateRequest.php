<?php

namespace App\Http\Requests\GoodsType;

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
//        $user = Auth::user();

//        return $user->can('goods-type');

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
            'goods_type_name' => 'required|max:255',
            'goods_type_desc' => 'required|max:255',
            'goods_type_leaset' => 'required|integer',
        ];
    }
}
