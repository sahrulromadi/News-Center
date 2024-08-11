<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::Create(['name' => 'Super Admin']);
        $editorRole = Role::Create(['name' => 'Editor']);
        $writerRole = Role::Create(['name' => 'Writer']);

        Permission::firstOrCreate(['name' => 'Create News']);
        Permission::firstOrCreate(['name' => 'Store News']);
        Permission::firstOrCreate(['name' => 'Edit News']);
        Permission::firstOrCreate(['name' => 'Update News']);
        Permission::firstOrCreate(['name' => 'Status News']);
        Permission::firstOrCreate(['name' => 'Update Status News']);
        Permission::firstOrCreate(['name' => 'Draft']);

        $writerRole->givePermissionTo(['Create News', 'Store News', 'Edit News', 'Update News', 'Draft']);
        $editorRole->givePermissionTo(['Status News', 'Update Status News']);
        $permissions = Permission::pluck('id')->all();
        $superAdminRole->syncPermissions($permissions);

        $superAdmin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('admin123')
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
}
