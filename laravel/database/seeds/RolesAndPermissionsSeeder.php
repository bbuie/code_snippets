<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Permission::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // create permissions
        Permission::create(['name' => 'access super-admin']);

        // create roles and assign permissions
        $role = Role::create(['name' => 'super-admin']);
        $allPermissions = Permission::get()->pluck('name')->all();
        $role->givePermissionTo($allPermissions);
    }
}
