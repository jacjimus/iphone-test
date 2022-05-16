<?php

namespace App\Http\Controllers;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Models\UserLesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function update(Request $request, $id)
    {
        $achievements_leson_counts = Achievement::where('type', 'Lesson')->get()->pluck('name', 'type_count')->toArray();
        $lesson = UserLesson::findOrFail($id);
        if ($lesson->fill($request->all())->save()) {
            $watched = UserLesson::where([['user_id', '=', $lesson->user_id], ['watched', '=', true]])->count();
            $achievement_name = match (true) {
                in_array($watched, array_keys($achievements_leson_counts)) => $achievements_leson_counts[$watched],
                default => ''
            };
            if ($achievement_name && !$this->lessonWasWatched($lesson->user, $achievement_name)) {
                event(new AchievementUnlocked($achievement_name, $lesson->user));
            }
        }
    }

    private function lessonWasWatched($user, $achievement_name)
    {
        return UserAchievement::where('user_id', $user->id)->where('achievement', 'LIKE', $achievement_name)->exists();
    }
}
