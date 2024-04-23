<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'recepcionista']);
        $role3 = Role::create(['name' => 'sastre']);
        $role4 = Role::create(['name' => 'cliente']);

        Permission::create(['name' => 'auth.logout'])->syncRoles([$role1, $role2, $role3, $role4]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.enable'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.disable'])->syncRoles([$role1]);
        Permission::create(['name' => 'orders.index'])->syncRoles([$role1, $role2, $role3]);
    }
}
