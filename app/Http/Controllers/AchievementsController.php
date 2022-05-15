<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserBadge;
use Illuminate\Support\Facades\DB;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => $this->unlockedAchievements($user->id),
            'next_available_achievements' => $this->nextAvailableAchievements($user->id),
            'current_badge' => $this->currentBadge($user->id),
            'next_badge' => $this->nextBadge($user->id),
            'remaing_to_unlock_next_badge' => $this->remainingToUnlock($user->id)
        ]);
    }

    protected function unlockedAchievements($id): array
    {
        return  UserAchievement::where('user_id', $id)->get()->pluck('achievement')->toArray();
    }

    protected function nextAvailableAchievements($id): array
    {
        $lesson = DB::table('achievements')
            ->select('name')
            ->where('type', 'Lesson')
            ->whereNotIn('name', UserAchievement::where('user_id', $id)->get()->pluck('achievement'))
            ->orderBy('id')
            ->limit(1)
            ->get();

        $comment = DB::table('achievements')
            ->select('name')
            ->where('type', 'Comment')
            ->whereNotIn('name', UserAchievement::where('user_id', $id)->get()->pluck('achievement'))
            ->orderBy('id')
            ->limit(1)
            ->get();

        return ['lesson' => $lesson->toArray(), 'comment' => $comment->toArray()];
    }

    protected function currentBadge($id): string
    {
        return UserBadge::where('user_id', $id)->orderBy('id', 'desc')->firstOrFail()->badge_name ?? '';
    }

    protected function nextBadge($id): string
    {
        return DB::table('badges')
            ->select('name')
            ->whereNotIn('name', UserBadge::where('user_id', $id)->get()->pluck('badge_name'))
            ->first()->name ?? '';
    }

    protected function remainingToUnlock($id): int
    {
        $next_achievements_requirements_count =  DB::table('badges')
            ->select('achievements')
            ->whereNotIn('name', UserBadge::where('user_id', $id)->get()->pluck('badge_name'))
            ->first()->achievements;
        $current_chievements_count = UserAchievement::where('user_id', $id)->count();

        return (int) $next_achievements_requirements_count - $current_chievements_count;
    }
}
