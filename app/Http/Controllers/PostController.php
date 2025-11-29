<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createAssignment($id)
    {
        return view("assignment.create", compact("id"));
    }

    public function storeAssignment(Request $request, $id)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "content" => "nullable|string",
            "due" => "required",
            "files.*" => "nullable|file|max:10240",
        ]);

        $classroom = Classroom::with('members')->find($id);
        $post = Post::where('id', 1);

        $post = Post::create([
            "user_id" => Auth::user()->id,
            "classroom_id" => $classroom->id,
            "title" => $request->title,
            "content" => $request->content,
            "due" => $request->due,
            "type" => "assignment",
        ]);

        $this->uploadPostFiles($request, $post);
        $this->generateSubmissions($post, $classroom);
        return redirect()->back()->with(["success" => "Tugas berhasil diupload!"]);
    }
}
