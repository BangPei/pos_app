<?php

namespace App\Http\Controllers;

use App\Models\TempTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login', [
            "title" => "Login Page"
        ]);
    }


    public function authenticate(Request $request)
    {

        try {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                TempTransaction::where('user_id', auth()->user()->id)->delete();
                return redirect()->intended('/');
            }
            return back()->with('LoginError', 'Username atau Password Tidak Valid');
        } catch (\Throwable $th) {
            return back()->with('LoginError', 'Server Error, Silahkan Coba lagi !');
        }
    }

    public function logout(Request $request)
    {
        TempTransaction::where('user_id', auth()->user()->id)->delete();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
