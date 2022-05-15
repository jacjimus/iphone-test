<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class AchievementsUnlockedListenerTest extends TestCase
{
    /**
     * @var Request|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = Mockery::mock(Request::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_achievement_unlocked_and_triggers_event()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
