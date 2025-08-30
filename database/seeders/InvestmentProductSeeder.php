<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvestmentProduct;

class InvestmentProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if products already exist
        if (InvestmentProduct::count() > 0) {
            $this->command->info('Investment products already exist, skipping seeding.');
            return;
        }

        $packages = [
            [
                'name' => 'Mc Queen',
                'description' => 'Perfect for beginners. Start your investment journey with this low-risk package.',
                'min_amount' => 20000.00,
                'max_amount' => 250000.00,
                'daily_rate' => 8,
                'duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Balmain',
                'description' => 'Balanced risk and returns. Ideal for moderate investors looking for steady growth.',
                'min_amount' => 450000.00,
                'max_amount' => 3500000.00,
                'daily_rate' => 12,
                'duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Goldman',
                'description' => 'High returns for serious investors. Maximum profit potential with longer duration.',
                'min_amount' => 6500000.00,
                'max_amount' => 35000000.00,
                'daily_rate' => 15,
                'duration_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            try {
                InvestmentProduct::create($package);
                $this->command->info("Created investment package: {$package['name']}");
            } catch (\Exception $e) {
                $this->command->warn("Failed to create package {$package['name']}: " . $e->getMessage());
            }
        }

        $this->command->info('Investment products seeding completed.');
    }
}
