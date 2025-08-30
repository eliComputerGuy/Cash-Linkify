<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            $this->call([
                InvestmentProductSeeder::class,
                LevelSeeder::class,
            ]);
            
            $this->command->info('Database seeding completed successfully.');
        } catch (\Exception $e) {
            $this->command->error('Database seeding failed: ' . $e->getMessage());
            // Don't throw the exception to prevent deployment failure
        }
        
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
