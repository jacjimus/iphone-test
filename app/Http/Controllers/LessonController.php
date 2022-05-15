<?php

namespace App\Http\Controllers;

use App\Events\AchievementUnlocked;
use App\Models\UserLesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function update(Request $request, $id)
    {
        $lesson = UserLesson::findOrFail($id);
        if ($lesson->fill($request->all())->save()) {
            $watched = UserLesson::where([['user_id', '=', $lesson->user_id], ['watched', '=', 1]])->count();
            $achievement_name = match ($watched) {
                1 => 'First Lesson Watched',
                5 =>  '5 Lessons Watched',
                10 =>  '10 Lessons Watched',
                25 =>  '25 Lessons Watched',
                50 =>  '50 Lessons Watched',
                default => ''
            };
            if ($achievement_name) {
                event(new AchievementUnlocked($achievement_name, $lesson->user));
            }
        }
    }
}
