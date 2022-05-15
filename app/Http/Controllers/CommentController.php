<?php

namespace App\Http\Controllers;

use App\Events\AchievementUnlocked;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;
        if ($comment->fill($request->all())->save()) {
            $commentsWritten = Comment::where('user_id', $comment->user_id)->count();
            $achievement_name = match ($commentsWritten) {
                1 => 'First Comment Written',
                3 => '3 Comments Written',
                5 => '5 Comments Written',
                10 => '10 Comments Written',
                20 => '20 Comments Written',
                default => ''
            };
            if ($achievement_name) {
                event(new AchievementUnlocked($achievement_name, $comment->user));
            }
        }
    }
}
