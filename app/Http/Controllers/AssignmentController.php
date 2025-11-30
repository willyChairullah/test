<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function assignmentClass($id)
    {
        $userId = Auth::user()->id;
        $isAuthor = $userId === Classroom::find($id)->user_id;
        $classroom = Classroom::with(['posts' => function ($q) {
            $q->where('type', 'assignment');
        }])->findOrFail($id);

        foreach ($classroom->posts as $post) {
            $submitted = $post->submission()->whereIn('status', ['done', 'graded'])->count();
            $pending = $post->submission()->where('status', 'pending')->count();

            $post->submitted = $submitted;
            $post->pending = $pending;
        }

        return view("assignment.index", compact("classroom", "id", "isAuthor"));
    }
}