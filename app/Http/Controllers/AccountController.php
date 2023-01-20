<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $title = 'Akun';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => '',
            'label'  => 'Akun'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb
        ];

        return view('account.index', compact('data'));
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'password_sekarang' => 'required',
            ]);
            if (!Hash::check($request->password_sekarang, auth()->user()->password)) {
                return back()->withErrors([
                    'password_sekarang' => ['password sekarang salah.']
                ]);
            }
            $request->validate([
                'password_baru'     => 'required|min:5|confirmed',
            ]);

            $user = User::find(auth()->user()->id);
            $user->update([
                'password' => Hash::make($request->password_baru)
            ]);

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'password telah di ubah, silahkan login kembali!');
        }
        $title = 'Ganti Password';
        $breadcrumb = [[
            'target' => route('dashboard'),
            'label'  => 'Dashboard'
        ], [
            'target' => route('account.index'),
            'label'  => 'Akun'
        ], [
            'target' => '',
            'label'  => 'Ganti Password'
        ]];

        $data = [
            'title'         => $title,
            'breadcrumb'    => $breadcrumb
        ];

        return view('account.change-password', compact('data'));
    }
}
