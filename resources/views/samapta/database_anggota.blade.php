@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER PANEL -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Database Anggota</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 tracking-[0.2em]">Manajemen Profil & Identitas Personil Polres</p>
        </div>
        
        <!-- REVISI URL: Mengarah ke /anggota/tambah-personil -->
        <a href="{{ url('/anggota/tambah-personil') }}" class="bg-[#0F172A] hover:bg-yellow-500 hover:text-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Ajukan Anggota Baru
        </a>
    </div>

    <!-- TABEL DATABASE ANGGOTA -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Personil Aktif</h4>
            <div class="text-[9px] font-black text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full uppercase tracking-widest">
                Data Terverifikasi Pimpinan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-slate-300 font-black text-[10px] uppercase tracking-widest border-b border-slate-50">
                        <th class="px-10 py-6 text-left">Nama & NRP Anggota</th>
                        <th class="px-6 py-6 text-center">Pangkat</th>
                        <th class="px-6 py-6 text-center">Satuan Kerja (Satker)</th>
                        <th class="px-10 py-6 text-right">Manajemen Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="font-bold text-slate-700">
                    @foreach($users as $u)
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                        <!-- Kolom Identitas -->
                        <td class="px-10 py-6 text-left">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-100 text-blue-900 rounded-xl flex items-center justify-center font-black text-xs shadow-sm">
                                    {{ substr($u->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-blue-900 text-sm leading-tight">{{ $u->nama_lengkap }}</p>
                                    <p class="text-slate-400 text-[9px] uppercase tracking-widest mt-1">NRP: {{ $u->nrp }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Kolom Pangkat -->
                        <td class="px-6 py-6 text-center">
                            <span class="bg-slate-50 text-slate-500 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter">
                                {{ $u->pangkat }}
                            </span>
                        </td>

                        <!-- Kolom Satker -->
                        <td class="px-6 py-6 text-center">
                            <p class="text-slate-500 text-xs uppercase tracking-tight">{{ $u->satker }}</p>
                        </td>

                        <!-- Kolom Aksi -->
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <!-- REVISI URL EDIT: Mengarah ke /anggota/edit-personil -->
                                <a href="{{ url('/anggota/edit-personil/'.$u->id) }}" class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm" title="Ajukan Perubahan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <!-- TOMBOL AJUKAN HAPUS (Sudah Benar) -->
                                <form action="{{ url('/pengajuan/ajukan-hapus/'.$u->id) }}" method="POST" onsubmit="return confirm('Kirim permohonan penghapusan anggota ini ke Kapolres?')">
                                    {{ csrf_field() }}
                                    <button type="submit" class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm" title="Ajukan Penghapusan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection