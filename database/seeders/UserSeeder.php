<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Marketing Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@bimasada.com'],
            [
                'name' => 'Manager Bimasada',
                'password' => Hash::make('manager123'),
            ]
        );
        $manager->assignRole('Marketing Manager');

        // Create Sales Users
        $sales1 = User::firstOrCreate(
            ['email' => 'sales@bimasada.com'],
            [
                'name' => 'Sales Bimasada',
                'password' => Hash::make('sales123'),
            ]
        );
        $sales1->assignRole('Sales');

        $mamat = User::firstOrCreate(
            ['email' => 'mamat@bimasada.com'],
            [
                'name' => 'Mamat Sales',
                'password' => Hash::make('password123'),
            ]
        );
        $mamat->assignRole('Sales');

        $nopal = User::firstOrCreate(
            ['email' => 'nopal@bimasada.com'],
            [
                'name' => 'Nopal Sales',
                'password' => Hash::make('password123'),
            ]
        );
        $nopal->assignRole('Sales');

        $this->command->info('✅ Users created successfully!');
        $this->command->info('👤 Marketing Manager: manager@bimasada.com / manager123');
        $this->command->info('👤 Sales: sales@bimasada.com / sales123');
        $this->command->info('👤 Sales: mamat@bimasada.com / password123');
        $this->command->info('👤 Sales: nopal@bimasada.com / password123');
    }
}
