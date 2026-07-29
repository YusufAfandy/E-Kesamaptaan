<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // Hanya user yang belum login yang bisa akses halaman login
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $this->validate($request, [
            'nrp'      => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Coba Login
        $credentials = $request->only('nrp', 'password');

        if (Auth::attempt($credentials)) {
            // Login Berhasil
            return redirect()->intended('/dashboard');
        }

        // 3. Gagal Login
        return redirect()->back()
            ->withInput($request->only('nrp'))
            ->withErrors(['nrp' => 'NRP atau Password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}