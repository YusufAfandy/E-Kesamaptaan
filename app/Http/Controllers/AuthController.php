<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;  // Tambahkan ini agar bisa akses tabel users
use App\Medis; // Tambahkan ini agar bisa akses tabel medis

class AuthController extends Controller
{
    public function __construct()
    {
        // Hanya user yang belum login yang bisa akses halaman login
        $this->middleware('guest')->except('logout');
    }

    // ==========================================================
    // BAGIAN YANG DIUBAH: showLogin()
    // ==========================================================
    public function showLogin()
    {
        // 1. Hitung total anggota dengan role 'personil'
        $totalAnggota = User::where('role', 'personil')->count();

        // 2. Hitung jumlah personil yang 'Memenuhi Syarat' (MS)
        $anggotaMS = Medis::where('status_kelayakan', 'Memenuhi Syarat')->count();

        // 3. Hitung persentase kesiapan (Mencegah pembagian dengan nol)
        $persentaseSiap = ($totalAnggota > 0) ? round(($anggotaMS / $totalAnggota) * 100) : 0;

        // Kirim hasil hitungan ke file login.blade.php
        return view('auth.login', compact('totalAnggota', 'persentaseSiap'));
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