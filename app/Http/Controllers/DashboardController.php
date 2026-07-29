<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Medis;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;

        // --- 1. DATA UMUM (Digunakan semua dashboard) ---
        $total = User::where('role', 'personil')->count();
        $ms = Medis::where('status_kelayakan', 'Memenuhi Syarat')->count();
        $tms = Medis::where('status_kelayakan', 'Tidak Memenuhi Syarat')->count();
        
        $kurus = Medis::where('bmi', '<', 18.5)->count();
        $ideal = Medis::whereBetween('bmi', [18.5, 25])->count();
        $overweight = Medis::whereBetween('bmi', [25.1, 30])->count();
        $obesitas = Medis::where('bmi', '>', 30)->count();

        $total_periksa = Medis::count() ?: 1; // Mencegah error pembagian nol
        $persen_siap = ($total > 0) ? round(($ms / $total) * 100) : 0;

        // --- 2. DATA KHUSUS KAPOLRES & SDM ---
        $atensi = Medis::with('user')->latest()->take(5)->get();

        // --- 3. DATA KHUSUS ADMIN URKES (Kotak Merah Kritis) ---
        $kritis = Medis::where('status_kelayakan', 'Tidak Memenuhi Syarat')
                    ->orWhere('bmi', '>=', 30)
                    ->orWhere('tensi_sistolik', '>=', 150)
                    ->with('user')->latest()->take(2)->get();

        // --- 4. KIRIM SEMUA VARIABEL KE VIEW ---
        return view('dashboard.' . $role, compact(
            'role', 'total', 'ms', 'tms', 'kurus', 'ideal', 
            'overweight', 'obesitas', 'total_periksa', 
            'persen_siap', 'atensi', 'kritis'
        ));
    }
}