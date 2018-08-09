<?php

namespace App\Http\Requests\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('user-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users,username|max:255',
            'note' => 'required',
            'role' => 'required|exists:roles,id',
            'password' => 'required|min:6|max:16'
        ];
    }

    public function messages()
    {
        $validations = [
            'username.required',
            'username.unique',
            'note.required',
            'role.required',
            'role.exists',
            'password.required',
            'password.min',
            'password.max',
        ];
        return translate_validation_messages('user', $validations);
    }
}
