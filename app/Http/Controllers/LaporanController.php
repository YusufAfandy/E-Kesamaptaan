<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LaporanController extends Controller
{
    public function rekap()
{
    // Mengambil user personil dengan riwayat medis dan samapta terakhir
    $data = \App\User::where('role', 'personil')
                ->with(['medis', 'samaptas'])
                ->get();

    return view('laporan.rekap', compact('data'));
}
}