@extends('layouts.app')

@section('content')
@if(session('success'))
<div id="notif-kapolres" class="mb-8 flex items-center justify-between p-6 bg-blue-600 text-white rounded-[2.5rem] shadow-xl animate-fade-in">
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold">✓</div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    <button onclick="document.getElementById('notif-kapolres').remove()" class="opacity-50 hover:opacity-100">✕</button>
</div>
@endif
<!-- 1. BANNER UTAMA -->
<div class="bg-[#1E293B] rounded-[2.5rem] p-10 mb-10 text-white flex justify-between items-center relative overflow-hidden shadow-2xl">
    <div class="relative z-10">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mb-2">Laporan Strategis — {{ date('d F Y') }}</p>
        <h3 class="text-4xl font-black italic uppercase tracking-tighter">Kesiapan Operasional Personil</h3>
        <p class="text-slate-400 text-sm mt-1 font-semibold uppercase tracking-widest">Polres Mojokerto — Analisis Data Terpadu</p>
    </div>
    <div class="text-right relative z-10">
        <h4 class="text-7xl font-black text-yellow-500 italic leading-none">{{ $persen_siap }}%</h4>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Personil Siap Bertugas</p>
    </div>
    <img src="{{ asset('img/logo-polri.png') }}" class="absolute right-[-30px] top-[-30px] w-80 opacity-10 pointer-events-none filter grayscale">
</div>

<!-- 2. NOTIFIKASI PERSETUJUAN (REVISI NO 3) -->
@php $pengajuan = \App\Pengajuan::where('status', 'PENDING')->get(); @endphp
@if($pengajuan->count() > 0)
<div class="mb-10 animate-fade-in">
    <div class="bg-yellow-50 border-2 border-yellow-200 rounded-[2rem] p-8 shadow-xl shadow-yellow-900/5">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-blue-900 font-black uppercase tracking-widest text-xs flex items-center gap-2">
                <span class="w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                Notifikasi Persetujuan ({{ $pengajuan->count() }})
            </h4>
            <p class="text-[10px] text-yellow-700 font-bold uppercase tracking-widest">Membutuhkan Verifikasi Kapolres</p>
        </div>
        
        <div class="space-y-4">
            @foreach($pengajuan as $p)
            <div class="bg-white p-5 rounded-2xl flex justify-between items-center border border-yellow-100 shadow-sm">
                <div>
                    <span class="bg-blue-100 text-blue-700 text-[8px] font-black px-2 py-0.5 rounded-full uppercase">{{ $p->tipe }} PERSONIL</span>
                    <p class="text-blue-900 font-black uppercase text-sm mt-1">{{ $p->nama_lengkap }} ({{ $p->nrp }})</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $p->pangkat }} — {{ $p->satker }}</p>
                </div>
                <div class="flex gap-3">
                    <!-- Tombol Setuju -->
                    <form action="{{ url('/pengajuan/setujui/'.$p->id) }}" method="POST">
                        {{ csrf_field() }}
                        <button class="bg-green-600 hover:bg-black text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase transition-all shadow-lg active:scale-95">Setujui</button>
                    </form>
                    <!-- Tombol Tolak -->
                    <form action="{{ url('/pengajuan/tolak/'.$p->id) }}" method="POST">
                        {{ csrf_field() }}
                        <button class="bg-red-100 hover:bg-red-600 text-red-600 hover:text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase transition-all">Tolak</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- 3. KARTU STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    @php
        $cards = [
            ['label' => 'Total Personil', 'val' => $total, 'sub' => 'Terdaftar', 'color' => 'slate'],
            ['label' => 'Siap Tugas', 'val' => $ms, 'sub' => 'Kondisi MS', 'color' => 'green'],
            ['label' => 'Rehabilitasi', 'val' => $tms, 'sub' => 'Kondisi TMS', 'color' => 'red'],
            ['label' => 'Obesitas', 'val' => $obesitas, 'sub' => 'Atensi Khusus', 'color' => 'red']
        ];
    @endphp
    @foreach($cards as $c)
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 border-b-4 {{ $c['label'] == 'Obesitas' ? 'border-red-600 animate-pulse' : 'border-'.$c['color'].'-500' }}">
        <p class="text-[9px] font-black text-slate-400 uppercase mb-4 tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 bg-{{ $c['color'] }}-500 rounded-full"></span> {{ $c['label'] }}
        </p>
        <p class="text-4xl font-black text-slate-800">{{ $c['val'] }}</p>
        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">{{ $c['sub'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-10">
    <!-- 4. DONUT CHART (DENGAN REVISI WARNA OBESITAS) -->
    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 self-start">Proporsi Status Kesehatan</h4>
        <div class="w-full relative">
            <canvas id="statusChart"></canvas>
            <div class="absolute inset-0 flex items-center justify-center flex-col pt-6 pointer-events-none">
                <p class="text-3xl font-black text-slate-800">{{ $persen_siap }}%</p>
                <p class="text-[8px] font-bold text-slate-400 uppercase">Ready</p>
            </div>
        </div>
    </div>

    <!-- 5. PROGRESS PER SATUAN -->
    <div class="lg:col-span-2 bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Kesiapan Per Satuan Kerja</h4>
        <div class="space-y-7">
            {{-- Pastikan nama variabelnya $data_satker (sama dengan di Controller) --}}
            @foreach($data_satker as $s)
            <div>
                <div class="flex justify-between text-[10px] font-black uppercase mb-2 tracking-widest">
                    <span class="text-slate-700">{{ $s['nama'] }}</span>
                    <span class="text-slate-400">{{ $s['persen'] }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-50 rounded-full overflow-hidden shadow-inner border border-slate-100">
                    <div class="h-full {{ $s['color'] }} rounded-full transition-all duration-1000" style="width: {{ $s['persen'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Siap', 'Overweight', 'Obesitas/TMS'],
            datasets: [{
                data: [{{ $ms }}, {{ $overweight }}, {{ $tms + $obesitas }}],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'], // REVISI: Obesitas warna Merah
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: { cutout: '82%', plugins: { legend: { display: false } } }
    });
</script>
@endsection