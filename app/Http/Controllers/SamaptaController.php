<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Samapta;

class SamaptaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Semua hasil tes ditampilkan sebagai riwayat, bukan hanya hasil terakhir.
        $riwayat = Samapta::with('user')->orderBy('periode', 'desc')->orderBy('id', 'desc')->get();

        return view('samapta.index', compact('riwayat'));
    }

    public function indexAnggota()
    {
        $users = User::where('role', 'personil')->orderBy('nama_lengkap')->get();

        return view('samapta.database_anggota', compact('users'));
    }

    public function create()
    {
        $personil = User::where('role', 'personil')->orderBy('nama_lengkap')->get();

        return view('samapta.create', compact('personil'));
    }

    /**
     * Simpan hasil tes baru.
     *
     * Setiap input baru dibuat sebagai record baru. Tidak ada update/upsert
     * terhadap record lama, sehingga riwayat tes sebelumnya tetap aman.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'     => 'required|exists:users,id',
            'periode'     => 'required|string|max:100',
            'lari_meter'  => 'required|numeric|min:0',
            'pull_up'     => 'required|numeric|min:0',
            'sit_up'      => 'required|numeric|min:0',
            'push_up'     => 'required|numeric|min:0',
            'shuttle_run' => 'required|numeric|min:0.01',
        ]);

        $user = User::where('id', $request->user_id)
            ->where('role', 'personil')
            ->firstOrFail();

        $nilai_akhir = $this->hitungNilai(
            $request->lari_meter,
            $request->pull_up,
            $request->sit_up,
            $request->push_up,
            $request->shuttle_run
        );

        Samapta::create([
            'user_id'     => $user->id,
            'periode'     => trim($request->periode),
            'lari_meter'  => $request->lari_meter,
            'pull_up'     => $request->pull_up,
            'sit_up'      => $request->sit_up,
            'push_up'     => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'nilai_akhir' => $nilai_akhir,
        ]);

        return redirect('/samapta')->with('success', 'Hasil penilaian jasmani baru berhasil disimpan. Riwayat lama tetap tersimpan.');
    }

    public function edit($id)
    {
        $samapta = Samapta::findOrFail($id);
        $personil = User::where('role', 'personil')->orderBy('nama_lengkap')->get();

        return view('samapta.edit', compact('samapta', 'personil'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id'     => 'required|exists:users,id',
            'periode'     => 'required|string|max:100',
            'lari_meter'  => 'required|numeric|min:0',
            'pull_up'     => 'required|numeric|min:0',
            'sit_up'      => 'required|numeric|min:0',
            'push_up'     => 'required|numeric|min:0',
            'shuttle_run' => 'required|numeric|min:0.01',
        ]);

        $user = User::where('id', $request->user_id)
            ->where('role', 'personil')
            ->firstOrFail();

        $nilai_akhir = $this->hitungNilai(
            $request->lari_meter,
            $request->pull_up,
            $request->sit_up,
            $request->push_up,
            $request->shuttle_run
        );

        $data = Samapta::findOrFail($id);

        // Hanya record dengan ID tersebut yang diubah.
        $data->update([
            'user_id'     => $user->id,
            'periode'     => trim($request->periode),
            'lari_meter'  => $request->lari_meter,
            'pull_up'     => $request->pull_up,
            'sit_up'      => $request->sit_up,
            'push_up'     => $request->push_up,
            'shuttle_run' => $request->shuttle_run,
            'nilai_akhir' => $nilai_akhir,
        ]);

        return redirect('/samapta')->with('success', 'Data nilai berhasil diperbarui dan dihitung ulang.');
    }

    public function editPersonil($id)
    {
        $user = User::findOrFail($id);

        return view('samapta.edit_personil', compact('user'));
    }

    public function destroy($id)
    {
        // Penghapusan hanya record nilai yang dipilih.
        $data = Samapta::findOrFail($id);
        $data->delete();

        return redirect('/samapta')->with('success', 'Data nilai jasmani tersebut telah dihapus.');
    }

    /**
     * Mesin penilaian dipusatkan agar store dan update selalu konsisten.
     */
    private function hitungNilai($lari_meter, $pull_up, $sit_up, $push_up, $shuttle_run)
    {
        $lari_efektif = min((float) $lari_meter, 2800);
        $nilai_lari = ($lari_efektif / 2800) * 100;

        $nilai_pull = min(((float) $pull_up / 18) * 100, 100);
        $nilai_sit = min(((float) $sit_up / 40) * 100, 100);
        $nilai_push = min(((float) $push_up / 40) * 100, 100);
        $nilai_shuttle = min((16 / (float) $shuttle_run) * 100, 100);

        return round(($nilai_lari + $nilai_pull + $nilai_sit + $nilai_push + $nilai_shuttle) / 5, 2);
    }
}
