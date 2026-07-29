@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER PANEL -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Kelola Personil</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 tracking-[0.2em]">Manajemen Database Kesamaptaan Jasmani</p>
        </div>
        <a href="{{ url('/samapta/create') }}" class="bg-[#0F172A] hover:bg-yellow-500 hover:text-slate-900 text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Entry Nilai Baru
        </a>
    </div>

    <!-- TABEL DATABASE NILAI -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Hasil Tes Samapta</h4>
            <div class="text-[9px] font-bold text-blue-900 bg-blue-50 px-4 py-1 rounded-full uppercase tracking-widest">
                Data Terkalkulasi Otomatis
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-slate-400 font-black text-[10px] uppercase tracking-widest border-b border-slate-50">
                        <th class="px-10 py-6 text-left">Personil</th>
                        <th class="px-6 py-6 text-center">Periode</th>
                        <th class="px-6 py-6 text-center">Lari (A)</th>
                        <th class="px-6 py-6 text-center">Nilai Akhir</th>
                        <th class="px-10 py-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-bold">
                    @foreach($riwayat as $s)
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black text-xs">
                                    {{ substr($s->user->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-blue-900 text-sm leading-tight">{{ $s->user->nama_lengkap }}</p>
                                    <p class="text-slate-400 text-[9px] uppercase tracking-widest mt-1">NRP: {{ $s->user->nrp }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center text-slate-500 text-xs uppercase">{{ $s->periode }}</td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-slate-700 text-sm">{{ $s->lari_meter }}m</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s->nilai_akhir }}</span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <!-- Tombol Hapus -->
                                <form action="{{ url('/samapta/'.$s->id.'/delete') }}" method="POST" onsubmit="return confirm('Hapus data nilai ini?')">
                                    {{ csrf_field() }}
                                    <button type="submit" class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm">
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