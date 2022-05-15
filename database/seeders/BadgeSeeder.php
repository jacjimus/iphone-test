<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Badge::truncate();
        Badge::insert(
            [
                ['name' => 'Beginner', 'achievements' => 0],
                ['name' => 'Intermediate', 'achievements' => 4],
                ['name' => 'Advanced', 'achievements' => 8],
                ['name' => 'Master', 'achievements' => 10],
                ]
        );
    }
}
