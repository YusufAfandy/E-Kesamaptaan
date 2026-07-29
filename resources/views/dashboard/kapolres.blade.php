@extends('layouts.app')

@section('content')
<!-- 1. BANNER UTAMA (Reference Style) -->
<div class="bg-[#1E293B] rounded-3xl p-10 mb-10 text-white flex justify-between items-center relative overflow-hidden shadow-2xl">
    <div class="relative z-10">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mb-2">Laporan Harian — {{ date('d F Y') }}</p>
        <h3 class="text-4xl font-black italic uppercase tracking-tighter">Kesiapan Operasional Personil</h3>
        <p class="text-slate-400 text-sm mt-1 font-semibold uppercase tracking-widest">Polres Kota — Seluruh Satuan Kerja</p>
    </div>
    <div class="text-right relative z-10">
        <h4 class="text-7xl font-black text-yellow-500 italic leading-none">{{ $persen_siap }}%</h4>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2 text-right">Personil Siap Bertugas</p>
    </div>
    <img src="{{ asset('img/logo-polri.png') }}" class="absolute right-[-30px] top-[-30px] w-80 opacity-10 pointer-events-none filter grayscale">
</div>

<!-- 2. KARTU STATISTIK (4 Kolom) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    @php
        $cards = [
            ['label' => 'Total Personil', 'val' => $total, 'sub' => 'Terdaftar Sistem', 'color' => 'slate'],
            ['label' => 'Siap Bertugas', 'val' => $ms, 'sub' => 'Kondisi Prima', 'color' => 'green'],
            ['label' => 'Dalam Rehabilitasi', 'val' => $tms, 'sub' => 'Butuh Penanganan', 'color' => 'red'],
            ['label' => 'Dalam Pemantauan', 'val' => $overweight + $obesitas, 'sub' => 'Observasi Aktif', 'color' => 'yellow']
        ];
    @endphp
    @foreach($cards as $c)
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 border-b-4 border-{{ $c['color'] }}-500 hover:translate-y-[-5px] transition-all duration-300">
        <p class="text-[9px] font-black text-slate-400 uppercase mb-4 tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 bg-{{ $c['color'] }}-500 rounded-full"></span> {{ $c['label'] }}
        </p>
        <p class="text-4xl font-black text-slate-800">{{ $c['val'] }}</p>
        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">{{ $c['sub'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-10">
    <!-- 3. DONUT CHART -->
    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 self-start">Proporsi Status Kesehatan</h4>
        <div class="w-full relative">
            <canvas id="statusChart"></canvas>
            <div class="absolute inset-0 flex items-center justify-center flex-col pt-6 pointer-events-none">
                <p class="text-3xl font-black text-slate-800">{{ $persen_siap }}%</p>
                <p class="text-[8px] font-bold text-slate-400 uppercase">Rata-rata</p>
            </div>
        </div>
    </div>

    <!-- 4. PROGRESS PER SATUAN -->
    <div class="lg:col-span-2 bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Kesiapan Per Satuan Kerja</h4>
        <div class="space-y-7">
            @php $satker = [['n' => 'Sat Reskrim', 'p' => 85, 'c' => 'bg-green-500'], ['n' => 'Sat Lantas', 'p' => 60, 'c' => 'bg-yellow-500'], ['n' => 'Sat Sabhara', 'p' => 45, 'c' => 'bg-red-500'], ['n' => 'Sat Intelkam', 'p' => 100, 'c' => 'bg-green-500']]; @endphp
            @foreach($satker as $s)
            <div>
                <div class="flex justify-between text-[10px] font-black uppercase mb-2 tracking-widest">
                    <span class="text-slate-700">{{ $s['n'] }}</span>
                    <span class="text-slate-400">{{ $s['p'] }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-50 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full {{ $s['c'] }} rounded-full transition-all duration-1000" style="width: {{ $s['p'] }}%"></div>
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
            labels: ['Siap', 'Pemantauan', 'Rehabilitasi'],
            datasets: [{
                data: [{{ $ms }}, {{ $overweight + $kurus }}, {{ $tms }}],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: { cutout: '80%', plugins: { legend: { display: false } } }
    });
</script>
@endsection