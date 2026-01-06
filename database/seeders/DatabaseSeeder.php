<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,  // Create roles & permissions FIRST
            UserSeeder::class,             // Create users & assign roles SECOND
            InvoiceSeeder::class,          // Use existing users
            SuratPerjanjianSeeder::class,  // Use existing users
            KuitansiSeeder::class,         // Use existing users
        ]);
    }
}
