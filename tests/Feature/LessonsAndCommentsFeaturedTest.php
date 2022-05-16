<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserBadge;
use App\Models\UserLesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LessonsAndCommentsFeaturedTest extends TestCase
{
    private User $user;

    private UserLesson $user_lesson;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
        UserLesson::truncate();
        Comment::truncate();
        UserBadge::truncate();
    }

    private function createUser(): Model
    {
        return User::factory()->create();
    }

    private function createUserLesson(): void
    {
        User::factory()
            ->count(1)
            ->create()->each(function ($user) {
                $this->user = $user;
                Lesson::factory()
                    ->count(1)
                    ->create()->each(function ($lesson) use ($user) {
                        $this->user_lesson = UserLesson::create(['user_id' => $user->id , 'lesson_id' => $lesson->id , 'watched' => false]);
                    });
            });
    }

    public function test_user_achievements_endpoint_returns_given_json_response()
    {
        $user = $this->createUser();
        $this->get(url("users/$user->id/achievements"))
         ->assertJsonStructure([
              'unlocked_achievements',
              'next_available_achievements',
              'current_badge',
              'next_badge',
              'remaining_to_unlock_next_badge']);
    }

    /**
     * Test if Achievement Unlocking event is triggered when user writes first comment!
     *
     * @return void
     */
    public function test_achievement_unlocked_after_user_has_written_first_comment()
    {
        $response = $this->post(url('api/comments'), ['user_id' => 1 , 'body' => 'this is the first test comment'])
            ->assertSuccessful();
        $this->assertDatabaseHas('comments', ['user_id' => 1 , 'body' => 'this is the first test comment']);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    /**
     * Test if Achievement is locked when user watches the first lesson
     */
    public function test_achievement_unlocked_after_user_has_watched_first_lesson()
    {
        $this->createUserLesson();
        $response = $this->put(url('api/lesson/'.$this->user_lesson->id), ['watched' => true])
        ->assertSuccessful();
        $this->assertDatabaseHas('lesson_user', ['user_id' => $this->user->id, 'watched' => 1]);

        Event::assertDispatched(AchievementUnlocked::class);
    }

    public function test_if_badge_is_unlocked_when_achievement_is_unlocked()
    {
        UserAchievement::truncate();
        $this->createUserLesson();
        $response = $this->post(url('api/comments/'), ['user_id' => $this->user_lesson->id , 'body' => 'this is a test comment'])
            ->assertSuccessful();
        $this->assertDatabaseHas('comments', ['user_id' => 1 , 'body' => 'this is a test comment']);

        Event::assertDispatched(AchievementUnlocked::class);
        UserAchievement::factory()->create(['user_id' => $this->user->id , 'achievement' => Achievement::first()->name]);

        $this->assertDatabaseHas('user_achievements', ['user_id' => $this->user->id]);
    }

    public function test_user_cannot_watch_lesson_that_is_not_subscribed_to()
    {
        $user = $this->createUser();
        $response = $this->put(url('api/lesson/'.$user->id), ['watched' => true]);
        $response->assertNotFound();
    }

    public function test_achievement_cannot_be_unlocked_by_watching_same_lesson_multiple_times()
    {
        UserAchievement::truncate();
        $this->createUserLesson();
        $this->assertDatabaseHas('lesson_user', ['id' => $this->user_lesson->id, 'watched' => false]);

        $this->put(url('api/lesson/'.$this->user_lesson->id), ['watched' => true])
            ->assertSuccessful();
        Event::assertDispatched(AchievementUnlocked::class);

        UserAchievement::factory()->create(['user_id' => $this->user->id , 'achievement' => Achievement::first()->name]);
        for ($i = 1; $i < 10; $i++) {
            $this->put(url('api/lesson/'.$this->user_lesson->id), ['watched' => true])
                ->assertSuccessful();
        }
        $this->assertDatabaseCount('user_achievements', 1);
    }
}
