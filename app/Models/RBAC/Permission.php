<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected  $fillable = ['name', 'display_name', 'group_name', 'description'];

    /**
     * 多对多 模型关联 角色
     * @return [type]
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('entrust.role'),
            config('entrust.permission_role_table'),
            config('entrust.permission_foreign_key'),
            config('entrust.role_foreign_key')
        );
    }
}
