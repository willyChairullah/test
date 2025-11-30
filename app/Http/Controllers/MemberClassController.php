<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\MemberClass;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberClassController extends Controller
{
    public function index($id)
    {
        $userId = Auth::user()->id;
        $isAuthor = $userId === Classroom::find($id)->user_id;
        $author = Classroom::with("user")->where("id", $id)->first();
        $members = MemberClass::with("user")->where("classroom_id", $id)->get();
        return view("classroom.member", compact("members", "author", "isAuthor", "id"));
    }
}
