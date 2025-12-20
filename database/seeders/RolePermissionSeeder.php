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

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $marketingManager = Role::create(['name' => 'Marketing Manager']);
        $sales = Role::create(['name' => 'Sales']);

        // Assign Permissions to Marketing Manager (Full Access)
        $marketingManager->givePermissionTo([
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'delete-invoices',
            'export-invoices',
            'manage-users',
            'manage-roles',
        ]);

        // Assign Permissions to Sales (Limited Access)
        $sales->givePermissionTo([
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'export-invoices',
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

