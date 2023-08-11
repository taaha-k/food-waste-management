<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['permission-group-list',1],
            ['permission-group-create',1],
            ['permission-group-edit',1],
            ['permission-group-delete',1],
            ['permission-list',1],
            ['permission-create',1],
            ['permission-edit',1],
            ['permission-delete',1],
            ['role-list',2],
            ['role-create',2],
            ['role-edit',2],
            ['role-delete',2],
            ['food-waste-list',2],
            ['food-waste-create',2],
            ['food-waste-edit',2],
            ['food-waste-delete',2],
            ['food-waste-softdelete',2],
            ['food-waste-restore',2],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['0'],'group_id'=>$permission[1]]);
        }
    }
}
