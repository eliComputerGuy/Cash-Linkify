<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'Level 1', 'entry_fee' => 20000, 'reward_per_video' => 100, 'daily_tasks' => 15, 'max_withdrawal_weekly' => 9500],
            ['name' => 'Level 2', 'entry_fee' => 80000, 'reward_per_video' => 200, 'daily_tasks' => 25, 'max_withdrawal_weekly' => 19500],
            ['name' => 'Level 3', 'entry_fee' => 120000, 'reward_per_video' => 250, 'daily_tasks' => 35, 'max_withdrawal_weekly' => 25000],
            ['name' => 'Level 4', 'entry_fee' => 250000, 'reward_per_video' => 350, 'daily_tasks' => 45, 'max_withdrawal_weekly' => 37500],
            ['name' => 'Level 5', 'entry_fee' => 450000, 'reward_per_video' => 450, 'daily_tasks' => 45, 'max_withdrawal_weekly' => 67500],
            ['name' => 'Level 6', 'entry_fee' => 1000000, 'reward_per_video' => 550, 'daily_tasks' => 70, 'max_withdrawal_weekly' => 150000],
            ['name' => 'Level 7', 'entry_fee' => 1500000, 'reward_per_video' => 650, 'daily_tasks' => 100, 'max_withdrawal_weekly' => 225000],
            ['name' => 'Level 8', 'entry_fee' => 3500000, 'reward_per_video' => 750, 'daily_tasks' => 150, 'max_withdrawal_weekly' => 535000],
            ['name' => 'Level 9', 'entry_fee' => 6500000, 'reward_per_video' => 850, 'daily_tasks' => 250, 'max_withdrawal_weekly' => 975000],
            ['name' => 'Level 10', 'entry_fee' => 10000000, 'reward_per_video' => 1000, 'daily_tasks' => 350, 'max_withdrawal_weekly' => 1500000],
            ['name' => 'Level 11', 'entry_fee' => 25000000, 'reward_per_video' => 1800, 'daily_tasks' => 550, 'max_withdrawal_weekly' => 3750000],
            ['name' => 'Level 12', 'entry_fee' => 35000000, 'reward_per_video' => 2500, 'daily_tasks' => 750, 'max_withdrawal_weekly' => 5250000],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
