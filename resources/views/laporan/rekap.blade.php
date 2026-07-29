@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- HEADER LAPORAN -->
    <div class="flex justify-between items-end no-print">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Rekapitulasi Global</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em] mt-2">Database Kesiapan Jasmani & Kesehatan Personil</p>
        </div>
        <div class="flex gap-3">
            <!-- Tombol Cetak -->
            <button onclick="window.print()" class="bg-[#0F172A] hover:bg-black text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- TABEL REKAPITULASI -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-300 font-black text-[10px] uppercase tracking-widest border-b border-slate-50">
                        <th class="px-10 py-8">Data Personil</th>
                        <th class="px-6 py-8 text-center">Hasil Medis (TD/BMI)</th>
                        <th class="px-6 py-8 text-center">Status Medis</th>
                        <th class="px-6 py-8 text-center">Nilai Jasmani</th>
                    </tr>
                </thead>
                <tbody class="font-bold">
                    @foreach($data as $row)
                    @php 
                        $m = $row->medis->last(); 
                        $s = $row->samaptas->last(); 
                    @endphp
                    <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                        <td class="px-10 py-6">
                            <p class="text-blue-900 text-sm">{{ $row->nama_lengkap }}</p>
                            <p class="text-slate-400 text-[9px] uppercase tracking-widest">{{ $row->pangkat }} — {{ $row->nrp }}</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-slate-600 text-xs">{{ $m ? $m->tensi_sistolik.'/'.$m->tensi_diastolik : '-' }}</p>
                            <p class="{{ $m && $m->bmi > 25 ? 'text-red-500' : 'text-blue-500' }} text-[10px]">BMI: {{ $m ? $m->bmi : '-' }}</p>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($m)
                                <span class="px-4 py-1.5 rounded-full text-[9px] uppercase tracking-widest {{ $m->status_kelayakan == 'Memenuhi Syarat' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $m->status_kelayakan }}
                                </span>
                            @else
                                <span class="text-slate-300 text-[9px] italic font-normal tracking-widest">Belum Periksa</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s ? $s->nilai_akhir : '-' }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .rounded-[3rem] { border-radius: 0 !important; border: none !important; box-shadow: none !important; }
        aside { display: none !important; }
        .ml-64 { margin-left: 0 !important; }
    }
</style>
@endsection