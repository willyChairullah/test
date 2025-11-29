<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function editAssignment($id, $id_post)
    {
        $post = Post::with("postFile")->where("id", $id_post)->first();
        return view("assignment.edit", compact("post", "id", "id_post"));
    }

    public function updateAssignment(Request $request, $id, $id_post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due' => 'required',
            'content' => 'nullable|string',
            'files.*' => 'nullable|file|max:10240',
        ]);

        $post = Post::findOrFail($id_post);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'due' => $request->due,
        ]);

        if ($request->deleted_files) {
            $ids = explode(',', $request->deleted_files);
            foreach ($ids as $fileId) {
                $file = PostFile::find($fileId);
                if ($file) {
                    Storage::delete($file->file_path);
                    $file->delete();
                }
            }
        }

        if ($request->hasFile('files')) {
            $this->uploadPostFiles($request, $post);
        }

        return redirect()->back()->with('success', 'Assignment berhasil diupdate!');
    }

    private function uploadPostFiles(Request $request, Post $post)
    {
        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('post_files');

                $postFile = PostFile::create([
                    'post_id' => $post->id,
                    'user_id' => Auth::user()->id,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                ]);

                $uploadedFiles[] = [
                    'name' => $postFile->original_name,
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => round($file->getSize() / 1024 / 1024, 2),
                ];
            }
        }

        return $uploadedFiles;
    }

    public function deletePostFile($id, $id_file)
    {
        $file = PostFile::findOrFail($id_file);

        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        $file->delete();

        return response()->json(['message' => 'File berhasil dihapus']);
    }


    public function download($id, $id_file)
    {
        $file = PostFile::findOrFail($id_file);
        $filePath = storage_path('app/private/' . $file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $file->original_name);
    }
}
