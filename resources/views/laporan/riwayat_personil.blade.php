@extends('layouts.app')
@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-black text-blue-900 uppercase tracking-tighter">Riwayat: {{ $user->nama_lengkap }}</h2>
        <a href="{{ url('/laporan/rekap') }}" class="text-xs font-bold text-slate-400 hover:text-blue-900 uppercase">← Kembali</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-100">
            <h4 class="text-xs font-black text-slate-400 uppercase mb-8">Log Medis (Urkes)</h4>
            @foreach($user->medis as $m)
            <div class="p-6 bg-slate-50 rounded-[2rem] mb-4 flex justify-between items-center">
                <p class="text-[10px] font-black text-slate-500 uppercase">{{ date('d/m/Y', strtotime($m->tanggal_periksa)) }}</p>
                <p class="font-black text-blue-900">{{ $m->tensi_sistolik }}/{{ $m->tensi_diastolik }}</p>
                <p class="font-black {{ $m->bmi >= 30 ? 'text-red-600 animate-pulse' : 'text-blue-600' }}">{{ $m->bmi }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-[#0F172A] rounded-[3rem] p-10 text-white">
            <h4 class="text-xs font-black text-slate-500 uppercase mb-8">Log Jasmani (SDM)</h4>
            @foreach($user->samaptas as $s)
            <div class="p-6 bg-white/5 rounded-[2rem] mb-4 flex justify-between items-center">
                <p class="text-[10px] font-black text-blue-400">{{ $s->periode }}</p>
                <p class="text-2xl font-black text-yellow-500 italic">{{ $s->nilai_akhir }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection