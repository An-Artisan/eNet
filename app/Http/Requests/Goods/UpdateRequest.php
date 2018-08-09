<?php

namespace App\Http\Requests\Goods;

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

        return $user->can('repositories');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_title' => 'required|string',
            'goods_desc' => 'required|string',
            'goods_price' => 'required|integer',
            'goods_original_price' => 'required|integer',
            'goods_type_id' => 'required|integer',
            'goods_supplier_id' => 'required|integer',
            'goods_photo' => 'required|string',
            'goods_is_publish' => 'required|string',
            'goods_count' => 'required|integer',
        ];
    }
}
