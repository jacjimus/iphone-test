<?php

namespace App\Http\Controllers;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $achievements_comment_counts = Achievement::where('type', 'Comment')->get()->pluck('name', 'type_count')->toArray();

        $comment = new Comment;
        if ($comment->fill($request->all())->save()) {
            $commentsWritten = Comment::where('user_id', $request->user_id)->count();
            $achievement_name = match (true) {
                in_array($commentsWritten, array_keys($achievements_comment_counts)) => $achievements_comment_counts[$commentsWritten],
                default => ''
            };
            if ($achievement_name) {
                event(new AchievementUnlocked($achievement_name, $comment->user));
            }
        }
    }
}
