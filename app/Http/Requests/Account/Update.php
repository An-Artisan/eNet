<?php

namespace App\Http\Requests\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\User;

class Update extends FormRequest
{
    protected $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->user = User::findOrFail($this->route('user'));
        $user = Auth::user();
        return $user->can('user-update') || ($user->id == $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'max:255|unique:users,username,'.$this->user->id,
            'is_enabled' => 'boolean'
        ];
    }

    public function messages()
    {
        $validations = [
            'username.unique'
        ];
        return translate_validation_messages('user', $validations);
    }
}
