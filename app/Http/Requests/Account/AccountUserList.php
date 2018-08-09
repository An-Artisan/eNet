<?php

namespace App\Http\Requests\Account;

use App\Traits\OauthTrait;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AccountUserList extends FormRequest
{
    use OauthTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        return $user->can('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit'   => 'integer',
            'page'    => 'integer',
        ];
    }


}
