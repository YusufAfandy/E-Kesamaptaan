<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pengajuan;
use App\User;

class PengajuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // SDM: Ajukan Tambah Anggota
    public function ajukan(Request $request)
    {
        $this->validate($request, [
            'nrp' => 'required|unique:users,nrp',
            'nama_lengkap' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'satker' => 'required|string|max:255',
        ]);

        // Cegah pengajuan TAMBAH ganda yang masih menunggu persetujuan.
        $pending = Pengajuan::where('tipe', 'TAMBAH')
            ->where('nrp', $request->nrp)
            ->where('status', 'PENDING')
            ->exists();

        if ($pending) {
            return redirect()->back()->withInput()->with('error', 'NRP tersebut sudah memiliki pengajuan yang sedang menunggu persetujuan.');
        }

        Pengajuan::create([
            'tipe' => 'TAMBAH',
            'nrp' => $request->nrp,
            'nama_lengkap' => $request->nama_lengkap,
            'pangkat' => $request->pangkat,
            'satker' => $request->satker,
            'status' => 'PENDING'
        ]);

        return redirect('/samapta')->with('success', 'Permohonan penambahan anggota telah dikirim ke Kapolres.');
    }

    // SDM: Ajukan Edit Anggota
    public function ajukanEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'nama_lengkap' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'satker' => 'required|string|max:255',
        ]);

        Pengajuan::create([
            'tipe' => 'EDIT',
            'nrp' => $user->nrp,
            'nama_lengkap' => $request->nama_lengkap,
            'pangkat' => $request->pangkat,
            'satker' => $request->satker,
            'status' => 'PENDING'
        ]);

        return redirect('/samapta')->with('success', 'Permohonan perubahan data anggota telah dikirim ke Kapolres.');
    }

    // SDM: Ajukan Hapus Anggota
    public function ajukanHapus($id)
    {
        $user = User::findOrFail($id);

        Pengajuan::create([
            'tipe' => 'HAPUS',
            'nrp' => $user->nrp,
            'nama_lengkap' => $user->nama_lengkap,
            'pangkat' => $user->pangkat,
            'satker' => $user->satker,
            'status' => 'PENDING'
        ]);

        return redirect('/samapta')->with('success', 'Permohonan penghapusan anggota telah dikirim ke Kapolres.');
    }

    // KAPOLRES: Setujui satu pengajuan.
    public function setujui($id)
    {
        $p = Pengajuan::findOrFail($id);

        if ($p->status !== 'PENDING') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($p) {
            $this->prosesPersetujuan($p);
            $p->update(['status' => 'DISETUJUI']);
        });

        return redirect()->back()->with('success', 'Aksi ' . $p->tipe . ' berhasil dilaksanakan.');
    }

    /**
     * Setujui seluruh pengajuan PENDING pada satu satker.
     * Method ini ditambahkan karena route dan tombol sebelumnya sudah tersedia,
     * tetapi controller belum memiliki implementasinya.
     */
    public function setujuiSemua($satker)
    {
        $pengajuans = Pengajuan::where('satker', $satker)
            ->where('status', 'PENDING')
            ->orderBy('id')
            ->get();

        if ($pengajuans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pengajuan pending untuk ' . $satker . '.');
        }

        $berhasil = 0;

        DB::transaction(function () use ($pengajuans, &$berhasil) {
            foreach ($pengajuans as $p) {
                $this->prosesPersetujuan($p);
                $p->update(['status' => 'DISETUJUI']);
                $berhasil++;
            }
        });

        return redirect()->back()->with('success', $berhasil . ' pengajuan berhasil disetujui.');
    }

    /**
     * Menjalankan isi pengajuan TAMBAH/EDIT/HAPUS tanpa mengubah
     * record kesehatan atau samapta milik personil.
     */
    private function prosesPersetujuan(Pengajuan $p)
    {
        if ($p->tipe === 'TAMBAH') {
            // Jangan membuat personil ganda jika pengajuan diproses ulang.
            $existing = User::where('nrp', $p->nrp)->first();

            if (!$existing) {
                User::create([
                    'nrp' => $p->nrp,
                    'nama_lengkap' => $p->nama_lengkap,
                    'pangkat' => $p->pangkat,
                    'satker' => $p->satker,
                    'role' => 'personil',
                    'password' => bcrypt('polres123')
                ]);
            }
        } elseif ($p->tipe === 'EDIT') {
            User::where('nrp', $p->nrp)->update([
                'nama_lengkap' => $p->nama_lengkap,
                'pangkat' => $p->pangkat,
                'satker' => $p->satker
            ]);
        } elseif ($p->tipe === 'HAPUS') {
            User::where('nrp', $p->nrp)->delete();
        }
    }

    public function tolak($id)
    {
        $p = Pengajuan::findOrFail($id);

        if ($p->status !== 'PENDING') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $p->update(['status' => 'DITOLAK']);

        return redirect()->back()->with('error', 'Permohonan telah ditolak.');
    }

    public function indexPersetujuan()
    {
        $data = Pengajuan::where('status', 'PENDING')->latest()->get();

        return view('pengajuan.persetujuan', compact('data'));
    }
}
