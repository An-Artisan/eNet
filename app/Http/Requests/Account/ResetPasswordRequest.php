<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email|exists:verify_code,email',
            'code'      => 'required|alpha_num',
        ];
    }

    public function messages()
    {
        $validations = [
            'email.required',
            'email.email',
            'email.unique',
            'email.exists',
            'code.required',
            'code.alpha_num',
        ];

        return translate_validation_messages('app', $validations);
    }
}
