<?php

namespace App\Models\RBAC;

use Zizaco\Entrust\EntrustRole;

use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * 多对多 模型关联 权限
     * @return [type]
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('entrust.permission'),
            config('entrust.permission_role_table'),
            config('entrust.role_foreign_key'),
            config('entrust.permission_foreign_key')
        );
    }

    /**
     * 多对多 模型关联 用户
     * @return [type]
     */
    public function users()
    {
        return $this->belongsToMany(
            config('entrust.user'),
            config('entrust.role_user_table'),
            config('entrust.role_foreign_key'),
            config('entrust.user_foreign_key')
        );
    }
}
