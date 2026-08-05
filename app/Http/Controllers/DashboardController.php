<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Medis;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;

        // 1. Data Statistik Dasar (Semua Role Butuh)
        $total = User::where('role', 'personil')->count();
        $ms = Medis::where('status_kelayakan', 'Memenuhi Syarat')->count();
        $tms = Medis::where('status_kelayakan', 'Tidak Memenuhi Syarat')->count();
        
        $kurus = Medis::where('bmi', '<', 18.5)->count();
        $ideal = Medis::whereBetween('bmi', [18.5, 25])->count();
        $overweight = Medis::whereBetween('bmi', [25.1, 29.9])->count();
        $obesitas = Medis::where('bmi', '>=', 30)->count();

        $total_periksa = Medis::count() ?: 1; 
        $persen_siap = ($total > 0) ? round(($ms / $total) * 100) : 0;
        
        // 2. Data Tabel & Alert
        $atensi = Medis::with('user')->latest()->take(5)->get();
        $jumlah_kritis = Medis::where('status_kelayakan', 'Tidak Memenuhi Syarat')
                        ->orWhere('bmi', '>=', 30)
                        ->orWhere('tensi_sistolik', '>=', 150)
                        ->count();
        $kritis = Medis::where('status_kelayakan', 'Tidak Memenuhi Syarat')
                    ->orWhere('bmi', '>=', 30)
                    ->orWhere('tensi_sistolik', '>=', 150)
                    ->with('user')->latest()->take(2)->get();

        // ============================================================
        // 3. LOGIKA DATA SATKER (KHUSUS UNTUK GRAFIK KAPOLRES)
        // ============================================================
        $list_satker = ['Sat Reskrim', 'Sat Lantas', 'Sat Sabhara', 'Sat Intelkam'];
        $data_satker = [];

        foreach ($list_satker as $nama_satker) {
            $total_anggota = User::where('satker', $nama_satker)->count();
            $anggota_ms = User::where('satker', $nama_satker)
                ->whereHas('medis', function($query) {
                    $query->where('status_kelayakan', 'Memenuhi Syarat');
                })->count();

            $persen = ($total_anggota > 0) ? round(($anggota_ms / $total_anggota) * 100) : 0;

            $warna = 'bg-green-500';
            if($persen < 50) $warna = 'bg-red-500';
            elseif($persen < 80) $warna = 'bg-yellow-500';

            $data_satker[] = [
                'nama' => $nama_satker,
                'persen' => $persen,
                'color' => $warna
            ];
        }

        // 4. KIRIM SEMUANYA KE VIEW (Sangat Penting: 'data_satker' harus ada di sini!)
        return view('dashboard.' . $role, compact(
            'total', 'ms', 'tms', 'kurus', 'ideal', 'overweight', 'obesitas', 
            'total_periksa', 'persen_siap', 'atensi', 'kritis', 'jumlah_kritis', 
            'data_satker' 
        ));
    }
}