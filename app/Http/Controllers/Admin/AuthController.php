<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $remember = $request->remember ? true : false;

            $level = User::where('email', $request->email)
                ->where('level', 0)
                ->count();

            if ($level == 0) {
                return back()->withErrors([
                    'error' => 'Login error!',
                ]);
            }

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                return redirect()->intended('/admin');
            }

            return back()->withErrors([
                'error' => 'Login error!',
            ]);
        }

        return view('admin.auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin');
    }
}
