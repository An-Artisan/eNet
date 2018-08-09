<?php

namespace App\Http\Requests\Api\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\RBAC\Role;

class Update extends FormRequest
{
    protected $role;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->role = Role::findOrFail($this->route('role'));
        return Auth::user()->can('rbac');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255|unique:roles,name,'.$this->role->id,
            'display_name' => 'max:255|unique:roles,display_name,'.$this->role->id,
            'description' => 'max:255',
            
        ];
    }
}
