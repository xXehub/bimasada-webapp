<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Invoice Permissions
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'delete-invoices',
            'export-invoices',
            
            // User Management Permissions (Marketing Manager only)
            'manage-users',
            'manage-roles',
        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[$permission] = Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create Roles
        $marketingManager = Role::firstOrCreate(['name' => 'Marketing Manager', 'guard_name' => 'web']);
        $sales = Role::firstOrCreate(['name' => 'Sales', 'guard_name' => 'web']);

        // Assign Permissions to Marketing Manager (Full Access)
        $marketingManager->givePermissionTo([
            $createdPermissions['view-invoices'],
            $createdPermissions['create-invoices'],
            $createdPermissions['edit-invoices'],
            $createdPermissions['delete-invoices'],
            $createdPermissions['export-invoices'],
            $createdPermissions['manage-users'],
            $createdPermissions['manage-roles'],
        ]);

        // Assign Permissions to Sales (Limited Access)
        $sales->givePermissionTo([
            $createdPermissions['view-invoices'],
            $createdPermissions['create-invoices'],
            $createdPermissions['edit-invoices'],
            $createdPermissions['export-invoices'],
        ]);

        // Create default users
        $manager = User::create([
            'name' => 'Manager Bimasada',
            'email' => 'manager@bimasada.com',
            'password' => Hash::make('manager123'),
        ]);
        $manager->assignRole('Marketing Manager');

        $salesUser = User::create([
            'name' => 'Sales Bimasada',
            'email' => 'sales@bimasada.com',
            'password' => Hash::make('sales123'),
        ]);
        $salesUser->assignRole('Sales');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Marketing Manager: manager@bimasada.com / manager123');
        $this->command->info('Sales: sales@bimasada.com / sales123');
    }
}

