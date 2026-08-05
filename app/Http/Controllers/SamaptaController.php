<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Samapta;

class SamaptaController extends Controller
{
    public function __construct()
    {
        // Memastikan hanya user yang sudah login yang bisa mengakses
        $this->middleware('auth');
    }

    /**
     * MENU: NILAI SAMAPTA
     * Menampilkan daftar seluruh hasil tes jasmani yang sudah terkalkulasi.
     */
    public function index()
    {
        // Mengambil riwayat nilai beserta data personil terkait
        $riwayat = Samapta::with('user')->latest()->get();

        return view('samapta.index', compact('riwayat'));
    }

    /**
     * MENU: DATABASE ANGGOTA
     * Menampilkan daftar identitas personil untuk dikelola (Edit/Hapus via Approval).
     */
    public function indexAnggota()
    {
        // Hanya mengambil user dengan role personil
        $users = User::where('role', 'personil')->latest()->get();

        return view('samapta.database_anggota', compact('users'));
    }

    /**
     * FORM: ENTRY NILAI JASMANI
     * Menampilkan halaman input nilai Samapta A dan B.
     */
    public function create()
    {
        // Mengambil daftar personil untuk pilihan dropdown di form
        $personil = User::where('role', 'personil')->get();

        return view('samapta.create', compact('personil'));
    }

    /**
     * PROSES: SIMPAN & KALKULASI NILAI
     * Menghitung skor otomatis berdasarkan standar operasional Polri.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'     => 'required',
            'periode'     => 'required',
            'lari_meter'  => 'required|numeric',
            'pull_up'     => 'required|numeric',
            'sit_up'      => 'required|numeric',
            'push_up'     => 'required|numeric',
            'shuttle_run' => 'required|numeric',
        ]);

        // --- HITUNG SKOR (Sama dengan logika Update) ---
        $lari_efektif = min($request->lari_meter, 2800);
        $nilai_lari   = ($lari_efektif / 2800) * 100;

        $nilai_pull    = min(($request->pull_up / 18) * 100, 100);
        $nilai_sit     = min(($request->sit_up / 40) * 100, 100);
        $nilai_push    = min(($request->push_up / 40) * 100, 100);
        $nilai_shuttle = min((16 / $request->shuttle_run) * 100, 100);

        $nilai_akhir = round(($nilai_lari + $nilai_pull + $nilai_sit + $nilai_push + $nilai_shuttle) / 5, 2);

        // Simpan ke Database
        Samapta::create([
            'user_id'     => $request->user_id,
            'periode'     => $request->periode,
            'lari_meter'  => $request->lari_meter,
            'pull_up'     => $request->pull_up,
            'sit_up'      => $request->sit_up,
            'push_up'     => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'nilai_akhir' => $nilai_akhir,
        ]);

        return redirect('/samapta')->with('success', 'Hasil penilaian jasmani berhasil disimpan.');
    }

    /**
     * FORM: EDIT NILAI JASMANI (Update Baru)
     */
    public function edit($id)
    {
        $samapta = Samapta::findOrFail($id);
        $personil = User::where('role', 'personil')->get();

        return view('samapta.edit', compact('samapta', 'personil'));
    }

    /**
     * PROSES: UPDATE & RE-KALKULASI NILAI (Update Baru)
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id'     => 'required',
            'periode'     => 'required',
            'lari_meter'  => 'required|numeric',
            'pull_up'     => 'required|numeric',
            'sit_up'      => 'required|numeric',
            'push_up'     => 'required|numeric',
            'shuttle_run' => 'required|numeric',
        ]);

        // --- REVISI: HITUNG ULANG NILAI ---
        $lari_efektif = min($request->lari_meter, 2800);
        $nilai_lari   = ($lari_efektif / 2800) * 100;

        $nilai_pull    = min(($request->pull_up / 18) * 100, 100);
        $nilai_sit     = min(($request->sit_up / 40) * 100, 100);
        $nilai_push    = min(($request->push_up / 40) * 100, 100);
        $nilai_shuttle = min((16 / $request->shuttle_run) * 100, 100);

        $nilai_akhir = round(($nilai_lari + $nilai_pull + $nilai_sit + $nilai_push + $nilai_shuttle) / 5, 2);

        // Update ke Database
        $data = Samapta::findOrFail($id);
        $data->update([
            'user_id'     => $request->user_id,
            'periode'     => $request->periode,
            'lari_meter'  => $request->lari_meter,
            'pull_up'     => $request->pull_up,
            'sit_up'      => $request->sit_up,
            'push_up'     => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'nilai_akhir' => $nilai_akhir,
        ]);

        return redirect('/samapta')->with('success', 'Data nilai berhasil diperbarui dan dihitung ulang.');
    }

    /**
     * FORM: EDIT IDENTITAS PERSONIL
     */
    public function editPersonil($id)
    {
        $user = User::findOrFail($id);
        return view('samapta.edit_personil', compact('user'));
    }

    /**
     * PROSES: HAPUS DATA NILAI
     */
    public function destroy($id)
    {
        $data = Samapta::findOrFail($id);
        $data->delete();

        return redirect('/samapta')->with('success', 'Data nilai jasmani tersebut telah dihapus.');
    }
}