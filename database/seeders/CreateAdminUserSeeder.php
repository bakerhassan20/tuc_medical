<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '1122002942',
            'password' => bcrypt('12345678'),
            'roles_name' => ["سوبر_ادمن"],
            'avatar' =>'image/users/avatar.png',
            ]);

            $role = Role::create(['name' => 'سوبر ادمن']);
            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
    }
}
