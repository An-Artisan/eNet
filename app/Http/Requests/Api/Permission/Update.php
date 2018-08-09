<?php

namespace App\Http\Requests\Api\Permission;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\RBAC\Permission;
use Illuminate\Support\Facades\Auth;

class Update extends FormRequest
{
    protected $permission;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->permission = Permission::findOrFail($this->route('permission'));
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
            'display_name' => 'max:255|unique:permissions,display_name,'.$this->permission->id,
            'description' => 'max:255',
            
        ];
    }
}
