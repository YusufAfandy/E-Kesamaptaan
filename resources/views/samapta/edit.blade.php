@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- HEADER -->
    <div class="flex items-center gap-4">
        <a href="{{ url('/samapta') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-900 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Edit Nilai Jasmani</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">Koreksi Data Hasil Tes Personil</p>
        </div>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-12">
            <form action="{{ url('/samapta/'.$samapta->id.'/update') }}" method="POST">
                {{ csrf_field() }}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    <!-- SISI KIRI: DATA PESERTA -->
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nama Anggota Polisi</label>
                            <select name="user_id" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                                @foreach($personil as $p)
                                    <option value="{{ $p->id }}" {{ $samapta->user_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->nrp }} — {{ $p->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3 px-1">Periode Tes (Semester)</label>
                            <input type="text" name="periode" value="{{ $samapta->periode }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                        
                        <!-- ITEM TES A (LARI) -->
                        <div class="pt-6 border-t border-slate-50">
                            <h5 class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-4">Item Tes A (Lari 12 Menit)</h5>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Jarak Tempuh (Meter)</label>
                            <input type="number" name="lari_meter" value="{{ $samapta->lari_meter }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                    </div>

                    <!-- SISI KANAN: ITEM TES B -->
                    <div class="space-y-6">
                        <h5 class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-4">Item Tes B (Gerakan Fisik)</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Pull Up</label>
                                <input type="number" name="pull_up" value="{{ $samapta->pull_up }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Sit Up</label>
                                <input type="number" name="sit_up" value="{{ $samapta->sit_up }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Push Up</label>
                                <input type="number" name="push_up" value="{{ $samapta->push_up }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Shuttle Run (Detik)</label>
                                <input type="number" step="0.01" name="shuttle_run" value="{{ $samapta->shuttle_run }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700">
                            </div>
                        </div>

                        <!-- SCORING PREVIEW BOX -->
                        <div class="bg-yellow-500 rounded-[2.5rem] p-8 text-[#0F172A] relative overflow-hidden shadow-xl shadow-yellow-500/20 mt-6">
                            <p class="text-[10px] font-black uppercase tracking-widest mb-1 opacity-70">Scoring Engine</p>
                            <h4 class="text-3xl font-black italic uppercase tracking-tighter leading-none">Kalkulasi Ulang</h4>
                            <p class="text-[9px] font-bold uppercase mt-3 opacity-60">Nilai akhir akan otomatis dihitung ulang setelah diperbarui.</p>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL UPDATE -->
                <div class="mt-14 pt-8 border-t border-slate-50">
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-[#0F172A] font-black py-5 rounded-[1.5rem] shadow-2xl transition-all active:scale-[0.98] text-[10px] uppercase tracking-[0.2em]">
                        Simpan Perubahan & Hitung Ulang Skor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection