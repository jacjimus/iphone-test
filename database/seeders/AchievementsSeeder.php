<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Achievement::insert(
            [
            ['name' => 'First  Lesson', 'type' => 'Lesson', 'type_count' => 1],
            ['name' => '5 Lesson', 'type' => 'Lesson', 'type_count' => 5],
            ['name' => '10 Lesson', 'type' => 'Lesson', 'type_count' => 10],
            ['name' => '25 Lesson', 'type' => 'Lesson', 'type_count' => 25],
            ['name' => '50 Lesson', 'type' => 'Lesson', 'type_count' => 50],
            ['name' => 'First Comment Written', 'type' => 'Comment', 'type_count' => 1],
            ['name' => '3 Comments Written', 'type' => 'Comment', 'type_count' => 5],
            ['name' => '5 Comments Written', 'type' => 'Comment', 'type_count' => 5],
            ['name' => '10 Comment Written', 'type' => 'Comment', 'type_count' => 10],
            ['name' => '20 Comment Written', 'type' => 'Comment', 'type_count' => 20]]
        );
    }
}
