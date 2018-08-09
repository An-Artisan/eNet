<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRegisterRequest extends FormRequest
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
            'openid' => 'required',
            'nickname'      => 'required',
            'sex'      => 'required',
            'photo'      => 'required',
            'phone' => 'required|regex:/^1[1234567890][0-9]{9}$/',
            'code'  => 'required|exists:sms_code',
            'invate_code' => 'required|exists:users',
        ];
    }

}
