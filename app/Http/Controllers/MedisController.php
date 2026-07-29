<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Medis;

class MedisController extends Controller
{
    public function create() {
        // Ambil data personil saja untuk dipilih di dropdown
        $personil = User::where('role', 'personil')->get();
        return view('medis.create', compact('personil'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'user_id' => 'required',
            'tensi_sistolik' => 'required|numeric',
            'tensi_diastolik' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'bmi' => 'required',
            'status_kelayakan' => 'required',
        ]);

        Medis::create([
            'user_id' => $request->user_id,
            'tanggal_periksa' => date('Y-m-d'),
            'tensi_sistolik' => $request->tensi_sistolik,
            'tensi_diastolik' => $request->tensi_diastolik,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'bmi' => $request->bmi,
            'status_kelayakan' => $request->status_kelayakan,
            'catatan' => $request->catatan,
        ]);

        return redirect('/dashboard')->with('success', 'Data Medis Berhasil Disimpan!');
    }

    // 1. Menampilkan Form Edit
    public function edit($id) {
        $medis = Medis::findOrFail($id);
        $personil = User::where('role', 'personil')->get();

        return view('medis.edit', compact('medis', 'personil'));
    }

    // 2. Memproses Update Data
    public function update(Request $request, $id) {
        $this->validate($request, [
            'user_id' => 'required',
            'tensi_sistolik' => 'required|numeric',
            'tensi_diastolik' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'bmi' => 'required',
            'status_kelayakan' => 'required',
        ]);

        $medis = Medis::findOrFail($id);
        $medis->update([
            'user_id' => $request->user_id,
            'tensi_sistolik' => $request->tensi_sistolik,
            'tensi_diastolik' => $request->tensi_diastolik,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'bmi' => $request->bmi,
            'status_kelayakan' => $request->status_kelayakan,
            'catatan' => $request->catatan,
        ]);

        return redirect('/medis')->with('success', 'Data Medis Berhasil Diperbarui!');
    }

    // 3. Menghapus Data
    public function destroy($id) {
        $medis = Medis::findOrFail($id);
        $medis->delete();

        return redirect('/medis')->with('success', 'Data Medis Berhasil Dihapus!');
    }
    
    public function index() {
        $riwayat = Medis::with('user')->orderBy('created_at', 'desc')->get();
        return view('medis.index', compact('riwayat'));
    }
}