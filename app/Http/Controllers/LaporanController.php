<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Medis; // Patokan utama sekarang adalah tabel Medis
use App\User;
use App\Samapta;

class LaporanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Menampilkan Seluruh Log Pemeriksaan (Semua data lama & baru tampil)
     */
    public function rekap()
    {
        // Kita ambil SEMUA data medis, urutkan dari ID terbesar (terbaru)
        // Gabungkan dengan data user dan samapta yang terkait
        $dataMedis = Medis::with('user')->orderBy('id', 'desc')->get();

        return view('laporan.rekap', compact('dataMedis'));
    }

    /**
     * Riwayat Detail per Anggota (Halaman Sejarah Individu)
     */
    public function riwayatPersonil($id) {
        $user = User::with(['medis' => function($q){
            $q->orderBy('id', 'desc');
        }, 'samaptas' => function($q){
            $q->orderBy('id', 'desc');
        }])->findOrFail($id);

        return view('laporan.riwayat_personil', compact('user'));
    }
}