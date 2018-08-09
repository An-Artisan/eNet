<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Models\RBAC\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * 用户数据填充
     *
     * @return void
    */
    public function run()
    {
        $json = File::get("database/datas/users.json");
        $data = json_decode($json);
        $roleAdmin = Role::where('name', 'admin')->first();

        foreach ($data as $user) {
            $newUser = User::create(
                [
                    'username' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($user->password)
                ]
            );
            $roleAdmin->users()->sync($newUser);
        }
    }
}
