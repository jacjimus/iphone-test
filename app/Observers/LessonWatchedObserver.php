<?php

namespace App\Observers;

use App\Events\AchievementUnlocked;
use App\Models\UserLesson;

class LessonWatchedObserver
{
    public function updated(UserLesson $user_lesson)
    {
        if ($user_lesson->watched) {
            $watched = UserLesson::where([['user_id', '=', $user_lesson->user_id], ['watched', '=', 1]])->count();
            $achievement_name = match ($watched) {
                1 => 'First Lesson Watched',
            5 =>  '5 Lessons Watched',
            10 =>  '10 Lessons Watched',
            25 =>  '25 Lessons Watched',
            50 =>  '50 Lessons Watched',
                default => ''
            };
            if ($achievement_name) {
                event(new AchievementUnlocked($achievement_name, $user_lesson->user));
            }
        }
    }
}
