<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'review-invoices', // Marketing Manager can review and request revision
            
            // PKS (Surat Perjanjian) Permissions
            'view-pks',
            'create-pks',
            'edit-pks',
            'delete-pks',
            'approve-pks',
            'export-pks',
            
            // Kuitansi Permissions
            'view-kuitansi',
            'create-kuitansi',
            'edit-kuitansi',
            'delete-kuitansi',
            'export-kuitansi',
            
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
            // Invoice
            $createdPermissions['view-invoices'],
            $createdPermissions['create-invoices'],
            $createdPermissions['edit-invoices'],
            $createdPermissions['delete-invoices'],
            $createdPermissions['export-invoices'],
            $createdPermissions['review-invoices'],
            // PKS
            $createdPermissions['view-pks'],
            $createdPermissions['create-pks'],
            $createdPermissions['edit-pks'],
            $createdPermissions['delete-pks'],
            $createdPermissions['approve-pks'],
            $createdPermissions['export-pks'],
            // Kuitansi
            $createdPermissions['view-kuitansi'],
            $createdPermissions['create-kuitansi'],
            $createdPermissions['edit-kuitansi'],
            $createdPermissions['delete-kuitansi'],
            $createdPermissions['export-kuitansi'],
            // User Management
            $createdPermissions['manage-users'],
            $createdPermissions['manage-roles'],
        ]);

        // Assign Permissions to Sales (Limited Access - can create/edit but not delete/approve)
        $sales->givePermissionTo([
            // Invoice
            $createdPermissions['view-invoices'],
            $createdPermissions['create-invoices'],
            $createdPermissions['edit-invoices'],
            $createdPermissions['export-invoices'],
            // PKS (Sales cannot approve or delete)
            $createdPermissions['view-pks'],
            $createdPermissions['create-pks'],
            $createdPermissions['edit-pks'],
            $createdPermissions['export-pks'],
            // Kuitansi
            $createdPermissions['view-kuitansi'],
            $createdPermissions['create-kuitansi'],
            $createdPermissions['edit-kuitansi'],
            $createdPermissions['export-kuitansi'],
        ]);

        $this->command->info('✅ Roles and permissions seeded successfully!');
    }
}

