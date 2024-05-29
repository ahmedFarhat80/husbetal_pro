<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Admin
        Permission::create(['name' => 'View-Admins', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Admins', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Admins', 'guard_name' => 'web']);

        Permission::create(['name' => 'View-Roles', 'guard_name' => 'web']);
        // Permissions
        Permission::create(['name' => 'View-Permissions', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Permissions', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Permissions', 'guard_name' => 'web']);

        // Sections
        Permission::create(['name' => 'View-Sections', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Sections', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Sections', 'guard_name' => 'web']);

        // Doctors
        Permission::create(['name' => 'View-Doctors', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Doctors', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Doctors', 'guard_name' => 'web']);
        Permission::create(['name' => 'Active-Doctors', 'guard_name' => 'web']);

        //  Reservations Schedule
        Permission::create(['name' => 'View-Reservations', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Reservations', 'guard_name' => 'web']);
        Permission::create(['name' => 'Dawnlode-PDF', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-PDF', 'guard_name' => 'web']);


        // Complaints Department
        Permission::create(['name' => 'View-Complaints', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Complaints', 'guard_name' => 'web']);
    }
}
