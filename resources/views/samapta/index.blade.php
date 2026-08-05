@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER PANEL -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Nilai Samapta</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 tracking-[0.2em]">Database Hasil Tes Jasmani Terkalkulasi</p>
        </div>
        <a href="{{ url('/samapta/create') }}" class="bg-[#0F172A] hover:bg-yellow-500 hover:text-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Entry Nilai Jasmani
        </a>
    </div>

    <!-- TABEL DATABASE NILAI -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Update Terakhir Nilai Samapta</h4>
            <div class="text-[9px] font-black text-green-600 bg-green-50 px-4 py-1.5 rounded-full uppercase tracking-widest">
                Kalkulasi Rumus Polri Aktif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-300 font-black text-[10px] uppercase tracking-widest border-b border-slate-50">
                        <th class="px-10 py-8 text-left">Personil</th>
                        <th class="px-6 py-8 text-center">Periode Tes</th>
                        <th class="px-6 py-8 text-center">Jarak Lari (A)</th>
                        <th class="px-6 py-8 text-center">Score Akhir</th>
                        <th class="px-10 py-8 text-right">Aksi</th> <!-- TAMBAHAN KOLOM AKSI -->
                    </tr>
                </thead>
                <tbody class="font-bold text-slate-700">
                    @foreach($riwayat as $s)
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition group">
                        <!-- Personil -->
                        <td class="px-10 py-6 text-left">
                            <p class="text-blue-900 text-sm group-hover:text-blue-600 transition">{{ $s->user->nama_lengkap }}</p>
                            <p class="text-slate-400 text-[9px] uppercase mt-1">NRP: {{ $s->user->nrp }}</p>
                        </td>

                        <!-- Periode -->
                        <td class="px-6 py-6 text-center">
                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                {{ $s->periode }}
                            </span>
                        </td>

                        <!-- Lari -->
                        <td class="px-6 py-6 text-center">
                            <p class="text-slate-700 text-sm font-black">{{ $s->lari_meter }}m</p>
                            <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest">Jarak Tempuh</p>
                        </td>

                        <!-- Score Akhir -->
                        <td class="px-6 py-8 text-center">
                            <p class="text-3xl font-black text-blue-900 italic tracking-tighter leading-none">{{ $s->nilai_akhir }}</p>
                            <p class="text-[8px] text-green-500 font-bold uppercase mt-2 tracking-[0.2em]">Terkalkulasi</p>
                        </td>

                        <!-- TOMBOL EDIT & HAPUS -->
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ url('/samapta/'.$s->id.'/edit') }}" class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm" title="Edit Nilai">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                
                                <!-- Tombol Hapus -->
                                <form action="{{ url('/samapta/'.$s->id.'/delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data nilai kesamaptaan ini?')">
                                    {{ csrf_field() }}
                                    <button type="submit" class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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