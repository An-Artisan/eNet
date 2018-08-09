<?php

namespace App\Http\Requests\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\User;

class ChangePersonalPassword extends FormRequest
{
    protected $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|max:255',
            'password_new' => 'required|different:password|different:test_password',
            'password_new_repeat' => 'required|same:password_new'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'password_new.different' => 'sss'
    //         ];

    // }
}
