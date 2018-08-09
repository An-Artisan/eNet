<?php

namespace App\Http\Requests\GoodsTypeSecond;

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
        $user = Auth::user();

        return $user->can('goods-type');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_type_second_name' => 'required|max:255',
            'goods_type_second_desc' => 'required|max:255',
            'goods_type_id' => 'required|integer',
        ];
    }
}
