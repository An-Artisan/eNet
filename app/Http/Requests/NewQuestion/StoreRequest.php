<?php

namespace App\Http\Requests\NewQuestion;

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
            'question_title' => 'required|max:255',
            'question_desc' => 'required|max:255',
            'master_name' => 'required|max:255',
            'master_phone' => 'required|regex:/^1[1234567890][0-9]{9}$/'

        ];
    }
}
