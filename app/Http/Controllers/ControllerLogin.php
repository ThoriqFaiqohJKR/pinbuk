<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ControllerLogin extends Controller
{
    public function showLogin()
    {
        return view('auth.auth-login');
    }
    public function indexuser()
    {
        return view('user.buku-index');
    }

public function logout(Request $request)
{
    Auth::logout(); // logout pengguna dari guard default

    $request->session()->invalidate();   // invalidate session lama
    $request->session()->regenerateToken(); // buat ulang CSRF token

    return redirect('/login')->with('success', 'Berhasil logout.');
}

}
