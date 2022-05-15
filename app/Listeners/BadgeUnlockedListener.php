<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\UserBadge;

class BadgeUnlockedListener
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
     * @param \App\Events\BadgeUnlocked $event
     *
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        UserBadge::create(['user_id' => $event->user->id, 'badge_name' => $event->badge_name]);
    }
}
