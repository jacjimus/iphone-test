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
            ['name' => 'First  Lesson', 'type' => 'Lesson'],
            ['name' => '5 s Lesson', 'type' => 'Lesson'],
            ['name' => '10 s Lesson', 'type' => 'Lesson'],
            ['name' => '25 s Lesson', 'type' => 'Lesson'],
            ['name' => '50 s Lesson', 'type' => 'Lesson'],
            ['name' => 'First Comment Written', 'type' => 'Comment'],
            ['name' => '3 Comments Written', 'type' => 'Comment'],
            ['name' => '5 Comments Written', 'type' => 'Comment'],
            ['name' => '10 Comment Written', 'type' => 'Comment'],
            ['name' => '20 Comment Written', 'type' => 'Comment']]
        );
    }
}
