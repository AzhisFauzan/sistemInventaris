<?php

namespace App\Http\Controllers;

use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\DB;
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
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('users')
            ->where('name', $request->name)
            ->where('password', $request->password)
            ->first();

        if ($user) {
            Auth::loginUsingId($user->id);

            if ($user->role == 'admin') {
                return redirect('/dashboard')->with('pesan', 'Login Admin Success');
            } elseif ($user->role == 'teknisi') {
                return redirect('/inventaris')->with('pesan', 'Login Pegawai Success');
            }
        }

        return back()->with('error', 'Login gagal, password salah');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
