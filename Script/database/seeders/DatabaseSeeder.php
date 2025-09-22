<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BasicControlSeeder::class,
            FileStorageSeeder::class,
            GatewaySeeder::class,
            PageSeeder::class,
            LanguageSeeder::class,
            MaintenanceSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
