<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserLesson;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementsUnlockedListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        User::factory()
            ->count(3)
            ->create()->each(function ($user) {
                Lesson::factory()
                    ->count(5)
                    ->create()->each(function ($lesson) use ($user) {
                        UserLesson::create(['user_id' => $user->id , 'lesson_id' => $lesson->id , 'watched' => false]);
                    });
            });
    }

    /**
     * Test if Achievement Unlocking event is triggered when user writes first comment!
     *
     * @return void
     */
    public function test_achievement_unlocked_after_user_has_written_first_comment()
    {
        Event::fake();

        $response = $this->post(url('api/comments'), ['user_id' => 1 , 'body' => 'this is a test comment'])
            ->assertSuccessful();
        $this->assertDatabaseHas('comments', ['user_id' => 1 , 'body' => 'this is a test comment']);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    /**
     * Test if Achievement is locked when user watches the first lesson
     */
    public function test_achievement_unlocked_after_user_has_watched_first_lesson()
    {
        Event::fake();

        $response = $this->post(url('api/lesson/1'), ['watched' => 1])
            ->assertSuccessful();
        $this->assertDatabaseHas('lesson_user', ['user_id' => 1, 'lesson_id'=>1, 'watched' => 1]);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    public function test_if_badge_is_unlocked_when_achievement_is_unlocked()
    {
        Event::fake();

        $response = $this->post(url('api/lesson/1'), ['watched' => 1])
            ->assertSuccessful();
        $this->assertDatabaseHas('user_achievements', ['user_id' => 1, 'lesson_id'=>1, 'watched' => 1]);

        Event::assertDispatched(BadgeUnlocked::class);
    }
}
