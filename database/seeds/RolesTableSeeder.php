<?php
use Illuminate\Database\Seeder;
use App\Models\RBAC\Permission;
use App\Models\RBAC\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * 角色数据填充
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/datas/roles.json");
        $data = json_decode($json);

        foreach ($data as $role) {
            $role = Role::create(
                [
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'description' => $role->description
                ]
            );
        }

        // 为角色赋予权限
        $roleAdmin = Role::where('name', 'admin')->first();
        $roleAdmin->perms()->sync(Permission::all());
    }
}
