<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use App\Models\UserLesson;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(3)
            ->create()->each(function ($user) {
                Lesson::factory()
                    ->count(5)
                    ->create()->each(function ($lesson) use ($user) {
                        UserLesson::create(['user_id' => $user->id , 'lesson_id' => $lesson->id , 'watched' => false]);
                    });
            });
        $this->call(AchievementsSeeder::class);
    }
}
