<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\UserAchievement;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AchievementUnlocked $event
     *
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $userAchievement = new UserAchievement;
        $userAchievement->user_id = $event->user->id;
        $userAchievement->achievement = $event->achievement_name;
        if ($userAchievement->save()) {
            $achievements = UserAchievement::where('user_id', $event->user->id)->count();
            $badge_name = match ($achievements) {
                0 => 'Beginner',
               3 => 'Intermediate',
               7 => 'Advanced',
               9 => 'Master',
               default => ''
            };
            if ($badge_name) {
                event(new BadgeUnlocked($badge_name, $event->user));
            }
        }
    }
}
