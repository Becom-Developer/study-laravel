<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function authenticate(Request $req)
    {
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        return back()->withErrors([
            'message' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect(RouteServiceProvider::HOME);
    }
}
