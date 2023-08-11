<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Waseem Raza',
            'email' => 'waseemraza013@gmail.com',
            'slug' => 'ghulam-farid',
            'role_status' => 1,
            'status' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('123456789')
        ]);

        $role = Role::create(['name' => 'Developer']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
