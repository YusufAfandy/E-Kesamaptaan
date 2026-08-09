<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Medis;

class MedisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        // Hanya personil yang dapat dipilih untuk pemeriksaan.
        $personil = User::where('role', 'personil')->orderBy('nama_lengkap')->get();

        return view('medis.create', compact('personil'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'            => 'required|exists:users,id',
            'tensi_sistolik'     => 'required|numeric|min:1',
            'tensi_diastolik'    => 'required|numeric|min:1',
            'tinggi_badan'       => 'required|numeric|min:1',
            'berat_badan'        => 'required|numeric|min:1',
            'status_kelayakan'   => 'required|in:Memenuhi Syarat,Tidak Memenuhi Syarat',
            'catatan'            => 'nullable|string',
        ]);

        // Pastikan user yang dipilih memang personil.
        $user = User::where('id', $request->user_id)
            ->where('role', 'personil')
            ->firstOrFail();

        // BMI dihitung ulang di server agar data yang tersimpan konsisten
        // dengan tinggi/berat yang dikirim form.
        $tinggiMeter = ((float) $request->tinggi_badan) / 100;
        $bmi = round(((float) $request->berat_badan) / ($tinggiMeter * $tinggiMeter), 2);

        /*
         * PENTING:
         * Input baru selalu INSERT (Medis::create), bukan update/upsert.
         * Dengan demikian pemeriksaan sebelumnya tetap menjadi riwayat.
         */
        Medis::create([
            'user_id'           => $user->id,
            'tanggal_periksa'   => date('Y-m-d'),
            'tensi_sistolik'    => $request->tensi_sistolik,
            'tensi_diastolik'   => $request->tensi_diastolik,
            'tinggi_badan'      => $request->tinggi_badan,
            'berat_badan'       => $request->berat_badan,
            'bmi'               => $bmi,
            'status_kelayakan'  => $request->status_kelayakan,
            'catatan'           => $request->catatan,
        ]);

        return redirect('/medis')->with('success', 'Data pemeriksaan baru berhasil disimpan. Riwayat lama tetap tersimpan.');
    }

    public function edit($id)
    {
        $medis = Medis::findOrFail($id);
        $personil = User::where('role', 'personil')->orderBy('nama_lengkap')->get();

        return view('medis.edit', compact('medis', 'personil'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id'            => 'required|exists:users,id',
            'tensi_sistolik'     => 'required|numeric|min:1',
            'tensi_diastolik'    => 'required|numeric|min:1',
            'tinggi_badan'       => 'required|numeric|min:1',
            'berat_badan'        => 'required|numeric|min:1',
            'status_kelayakan'   => 'required|in:Memenuhi Syarat,Tidak Memenuhi Syarat',
            'catatan'            => 'nullable|string',
        ]);

        $user = User::where('id', $request->user_id)
            ->where('role', 'personil')
            ->firstOrFail();

        $medis = Medis::findOrFail($id);

        $tinggiMeter = ((float) $request->tinggi_badan) / 100;
        $bmi = round(((float) $request->berat_badan) / ($tinggiMeter * $tinggiMeter), 2);

        // Update hanya record yang sedang diedit. Record pemeriksaan lain tidak disentuh.
        $medis->update([
            'user_id'           => $user->id,
            'tensi_sistolik'    => $request->tensi_sistolik,
            'tensi_diastolik'   => $request->tensi_diastolik,
            'tinggi_badan'      => $request->tinggi_badan,
            'berat_badan'       => $request->berat_badan,
            'bmi'               => $bmi,
            'status_kelayakan'  => $request->status_kelayakan,
            'catatan'           => $request->catatan,
        ]);

        return redirect('/medis')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Penghapusan hanya untuk record yang dipilih, bukan seluruh riwayat personil.
        $medis = Medis::findOrFail($id);
        $medis->delete();

        return redirect('/medis')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }

    public function index()
    {
        // Semua record ditampilkan agar riwayat lama tidak hilang dari daftar.
        $riwayat = Medis::with('user')->orderBy('tanggal_periksa', 'desc')->orderBy('id', 'desc')->get();

        return view('medis.index', compact('riwayat'));
    }
}
