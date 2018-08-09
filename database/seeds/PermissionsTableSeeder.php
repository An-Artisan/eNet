<?php
use Illuminate\Database\Seeder;
use App\Models\RBAC\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * 权限数据填充
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/datas/permissions.json");
        $data = json_decode($json);

        foreach ($data as $permission) {
            Permission::create(
                [
                    'name' => $permission->name,
                    'display_name' => $permission->display_name,
                    'description' => $permission->description
                ]
            );
        }
    }
}
