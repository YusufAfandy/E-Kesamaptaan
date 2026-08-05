<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pengajuan;
use App\User;

class PengajuanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // SDM: Ajukan Tambah Anggota
    public function ajukan(Request $request) {
        $this->validate($request, ['nrp' => 'required|unique:users,nrp', 'nama_lengkap' => 'required']);
        Pengajuan::create([
            'tipe' => 'TAMBAH', 'nrp' => $request->nrp, 'nama_lengkap' => $request->nama_lengkap,
            'pangkat' => $request->pangkat, 'satker' => $request->satker, 'status' => 'PENDING'
        ]);
        return redirect('/samapta')->with('success', 'Permohonan penambahan anggota telah dikirim ke Kapolres.');
    }

    // SDM: Ajukan Edit Anggota
    public function ajukanEdit(Request $request, $id) {
        $user = User::findOrFail($id);
        Pengajuan::create([
            'tipe' => 'EDIT', 'nrp' => $user->nrp, 'nama_lengkap' => $request->nama_lengkap,
            'pangkat' => $request->pangkat, 'satker' => $request->satker, 'status' => 'PENDING'
        ]);
        return redirect('/samapta')->with('success', 'Permohonan perubahan data anggota telah dikirim ke Kapolres.');
    }

    // SDM: Ajukan Hapus Anggota
    public function ajukanHapus($id) {
    // Ambil data personil yang mau dihapus
    $user = \App\User::findOrFail($id);

    // Simpan permohonan ke tabel pengajuans
    \App\Pengajuan::create([
        'tipe'          => 'HAPUS',
        'nrp'           => $user->nrp,
        'nama_lengkap'  => $user->nama_lengkap,
        'pangkat'       => $user->pangkat,
        'satker'        => $user->satker,
        'status'        => 'PENDING'
    ]);

    return redirect('/samapta')->with('success', 'Permohonan penghapusan anggota telah dikirim ke Kapolres.');
    }

    // KAPOLRES: Setujui (TAMBAH / EDIT / HAPUS)
    public function setujui($id) {
        $p = Pengajuan::findOrFail($id);
        
        if ($p->tipe == 'TAMBAH') {
            User::create([
                'nrp' => $p->nrp, 'nama_lengkap' => $p->nama_lengkap, 'pangkat' => $p->pangkat,
                'satker' => $p->satker, 'role' => 'personil', 'password' => bcrypt('polres123')
            ]);
        } elseif ($p->tipe == 'EDIT') {
            User::where('nrp', $p->nrp)->update([
                'nama_lengkap' => $p->nama_lengkap, 'pangkat' => $p->pangkat, 'satker' => $p->satker
            ]);
        } elseif ($p->tipe == 'HAPUS') {
            User::where('nrp', $p->nrp)->delete();
        }

        $p->update(['status' => 'DISETUJUI']);
        return redirect()->back()->with('success', 'Aksi ' . $p->tipe . ' berhasil dilaksanakan.');
    }

    public function tolak($id) {
        Pengajuan::findOrFail($id)->update(['status' => 'DITOLAK']);
        return redirect()->back()->with('error', 'Permohonan telah ditolak.');
    }

    public function indexPersetujuan() {
        $data = Pengajuan::where('status', 'PENDING')->latest()->get();
        return view('pengajuan.persetujuan', compact('data'));
    }
}