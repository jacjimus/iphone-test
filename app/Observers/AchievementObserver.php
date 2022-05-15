<?php

namespace App\Observers;

use App\Events\BadgeUnlocked;
use App\Models\UserAchievement;

class AchievementObserver
{
    public function saving(UserAchievement $achievement)
    {
        $achievements = UserAchievement::where('user_id', $achievement->user_id)->count();
        $badge_name = match ($achievements) {
            0 => 'Beginner',
            3 => 'Intermediate',
            7 => 'Advanced',
            9 => 'Master',
            default => ''
        };
        if ($badge_name) {
            event(new BadgeUnlocked($badge_name, $achievement->user));
        }
    }
}
