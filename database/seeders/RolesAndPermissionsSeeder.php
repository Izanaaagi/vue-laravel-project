<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = collect(['admin', 'user']);
        $permissions = collect(['change usernames', 'delete articles', 'create admin\'s topics']);

        $roles->each(function ($role) {
            Role::updateOrCreate([
                'name' => $role,
                'guard_name' => 'api'
            ]);
        });

        $permissions->each(function ($permission) {
            Permission::updateOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        });

        $adminRole = Role::findByName('admin', 'api');
        $adminRole->givePermissionTo(Permission::all());
    }
}
