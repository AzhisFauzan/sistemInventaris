<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthCtrl extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'regex:/^[A-Z\s]+$/',
            ],
            'password' => [
                'required',
                'max:10',
            ]
        ], [
            'name.regex' => 'Username harus menggunakan huruf besar semua.',
            'password.max' => 'Password maximal harus 10 karakter.',
            'name.required' => 'Username tidak boleh kosong.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        $user = DB::table('users')
            ->where('name', $request->name)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            Auth::loginUsingId($user->id);
            return redirect('/dashboard')->with('pesan', 'Login Success');
        }

        return back()->withErrors(['login_error' => 'Username atau Password salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
