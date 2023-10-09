<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Create entities']);
        Permission::create(['name' => 'See entities']);
        Permission::create(['name' => 'Create users']);
        Permission::create(['name' => 'See users']);
        Permission::create(['name' => 'Create workers']);
        Permission::create(['name' => 'See workers']);
        Permission::create(['name' => 'Create promoters']);
        Permission::create(['name' => 'See promoters']);
        Permission::create(['name' => 'Create work']);
        Permission::create(['name' => 'Create company']);
        Permission::create(['name' => 'See company']);
        Permission::create(['name' => 'Create machines']);
        Permission::create(['name' => 'See machines']);
        Permission::create(['name' => 'Assign company to work']);
        Permission::create(['name' => 'Create documentation templates']);
        Permission::create(['name' => 'Create documents types']);
        Permission::create(['name' => 'Assign documentation template to work']);
        Permission::create(['name' => 'Tracking documentation']);
        Permission::create(['name' => 'See work']);
        Permission::create(['name' => 'Upload documentation']);
        Permission::create(['name' => 'See documentation']);
        Permission::create(['name' => 'Delete documentation']);
        Permission::create(['name' => 'Validate documentation']);

        //Permissions ADMINISTRADOR
        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::whereNotIn('name', ['Create workers', 'See workers'])->get());

        //Permissions COMPANY
        $role = Role::create(['name' => 'Company']);
        $role->givePermissionTo(['See work', 'Upload documentation', 'See documentation', 'Delete documentation', 'Create company', 'See workers', 'Create workers', 'Create promoters']);

        //Permissions EXTERNAL
        $role = Role::create(['name' => 'External']);
        $role->givePermissionTo(['See work', 'See documentation']);

        //Permissions CONSTRUCTION MANAGER
        $role = Role::create(['name' => 'Construction_manager']);
        $role->givePermissionTo(['See work', 'See documentation']);


        //Permissions GUEST
        $role = Role::create(['name' => 'Guest']);
        $role->givePermissionTo(['See work', 'See documentation']);
    }
}
