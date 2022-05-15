<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;
use App\Models\Comment;
use App\Models\UserAchievement;
use App\Models\UserLesson;
use App\Observers\AchievementObserver;
use App\Observers\CommentObserver;
use App\Observers\LessonWatchedObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        AchievementUnlocked::class => [
            AchievementUnlockedListener::class
        ],

        BadgeUnlocked::class => [
            BadgeUnlockedListener::class
            ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Comment::observe(CommentObserver::class);
        UserLesson::observe(LessonWatchedObserver::class);
        UserAchievement::observe(AchievementObserver::class);
    }
}
