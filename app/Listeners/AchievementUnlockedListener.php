<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
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
        $userAchievement->save();
    }
}