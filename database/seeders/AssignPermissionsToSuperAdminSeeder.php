<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionsToSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super-Admin')->first();
        $permissions = Permission::all();
        $superAdminRole->syncPermissions($permissions);

        $user = User::find(1);
        $superAdminRole = Role::where('name', 'Super-Admin')->first();
        $user->assignRole($superAdminRole);
    }
}
