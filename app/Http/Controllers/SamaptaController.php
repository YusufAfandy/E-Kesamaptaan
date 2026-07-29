<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Samapta;

class SamaptaController extends Controller
{
    // Tambahkan fungsi index ini:
    public function index()
    {
    // 1. Ambil data dari tabel samaptas, gabungkan dengan data user (nama/nrp)
    $riwayat = \App\Samapta::with('user')->latest()->get();

    // 2. Buka file tampilan tabel (index.blade.php) dan kirim datanya
    return view('samapta.index', compact('riwayat'));
    }

    // 2. Menampilkan Form Input
    public function create() {
        // Tips: Kita bisa tambahkan filter agar hanya personil yang sudah diperiksa medis yang muncul
        $personil = User::where('role', 'personil')->get();
        return view('samapta.create', compact('personil'));
    }

    // 3. Menyimpan Data Baru
    public function store(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'periode' => 'required',
            'lari_meter' => 'required|numeric',
            'pull_up' => 'required|numeric',
            'sit_up' => 'required|numeric',
            'push_up' => 'required|numeric',
            'shuttle_run' => 'required|numeric',
        ]);

        // Rumus Kalkulasi
        // Tambahkan min(..., 100) agar nilai tidak meluap
        $nilai_lari = min(($request->lari_meter / 2400) * 100, 100);
        $nilai_pull = min(($request->pull_up / 18) * 100, 100);
        $nilai_sit  = min(($request->sit_up / 40) * 100, 100);
        $nilai_push = min(($request->push_up / 40) * 100, 100);
        $nilai_shuttle = min((16 / $request->shuttle_run) * 100, 100);

        $nilai_akhir = ($nilai_lari + $nilai_pull + $nilai_sit + $nilai_push + $nilai_shuttle) / 5;

        Samapta::create([
            'user_id' => $request->user_id,
            'periode' => $request->periode,
            'lari_meter' => $request->lari_meter,
            'pull_up' => $request->pull_up,
            'sit_up' => $request->sit_up,
            'push_up' => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'nilai_akhir' => round($nilai_akhir, 2)
        ]);

        // Setelah simpan, arahkan ke halaman DAFTAR (index)
        return redirect('/samapta')->with('success', 'Nilai Kesamaptaan Berhasil Disimpan!');
    }

    // 4. Fitur Hapus Data Nilai
    public function destroy($id) {
        $data = Samapta::findOrFail($id);
        $data->delete();
        return redirect('/samapta')->with('success', 'Data Nilai Berhasil Dihapus!');
    }
}