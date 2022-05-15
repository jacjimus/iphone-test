<?php

namespace App\Http\Controllers;

use App\Models\UserLesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function update(Request $request, $id)
    {
        $lesson = UserLesson::findOrFail($id);
        $lesson->fill($request->all())->save();
    }
}
