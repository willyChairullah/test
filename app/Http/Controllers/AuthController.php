<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function authentication(Request $request)
    {
        $credential = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
        public function  store(Request $request)
    {
        $validation = $request->validate([
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required",
            "password" => "required"
        ]);

        try {
            $randomNumber = rand(1, 9);
            $avatarPath = '/avatars/' . $randomNumber . '.png';

            $validation['photo'] = $avatarPath;
            User::create($validation);
            return redirect()->back()->with("success", "Registrasi Berhasil");
        } catch (\Throwable $th) {
            return redirect()->back()->with("fail", "Registrasi Gagal");
        }
    }
    public function logout(Request $request)
    {
        Auth::guard("web")->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login");
    }
}