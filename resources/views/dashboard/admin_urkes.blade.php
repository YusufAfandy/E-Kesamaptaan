@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- KOLOM KIRI: ALERTS & TABEL -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- 1. PERINGATAN MEDIS (RED BOX) -->
        <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-[2.5rem] p-8 shadow-xl shadow-red-200 text-white relative overflow-hidden">
            <div class="flex justify-between items-center mb-6 relative z-10">
                <h4 class="font-black uppercase tracking-[0.2em] text-[10px] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    Peringatan Medis
                </h4>
                <span class="bg-white/20 backdrop-blur-md px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">
                    {{ $jumlah_kritis }} ANGGOTA PERLU ATENSI
                </span>
            </div>
            
            <div class="space-y-4 relative z-10">
                @foreach($kritis as $k)
                <div class="bg-white rounded-[1.5rem] p-5 text-slate-800 flex justify-between items-center shadow-lg transition hover:scale-[1.01]">
                    <div>
                        <p class="font-black text-base uppercase leading-tight text-blue-900">{{ $k->user->nama_lengkap }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $k->user->nrp }}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            {{-- LABEL DINAMIS DENGAN WARNA --}}
                            @if($k->tensi_sistolik >= 140) <span class="bg-red-600 text-white animate-pulse px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest">Hipertensi</span> @endif
                            
                            @if($k->bmi < 18.5) <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-[8px] font-black uppercase">Underweight</span> @endif
                            @if($k->bmi >= 25 && $k->bmi < 30) <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-lg text-[8px] font-black uppercase">Overweight</span> @endif
                            @if($k->bmi >= 30) <span class="bg-red-600 text-white animate-pulse px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest">Obesitas</span> @endif
                            
                            @if($k->status_kelayakan == 'Tidak Memenuhi Syarat') <span class="bg-slate-800 text-white px-3 py-1 rounded-lg text-[8px] font-black uppercase">TMS</span> @endif
                        </div>
                    </div>
                    <div class="text-right border-l-2 border-slate-50 pl-6">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Tensi Darah</p>
                        <p class="text-2xl font-black {{ $k->tensi_sistolik >= 140 ? 'text-red-600 animate-pulse' : 'text-slate-800' }} leading-none">{{ $k->tensi_sistolik }}/{{ $k->tensi_diastolik }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- 2. TABEL PEMERIKSAAN TERBARU -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
             <div class="flex justify-between items-center mb-8">
                 <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pemeriksaan Terbaru</h4>
                 <a href="{{ url('/medis') }}" class="text-[9px] font-black text-blue-600 uppercase hover:underline tracking-widest">Kelola Semua Data →</a>
             </div>
             <table class="w-full text-left text-xs">
                 <thead class="text-slate-400 font-black tracking-widest border-b border-slate-50">
                     <tr>
                         <th class="pb-5">Anggota</th>
                         <th class="pb-5 text-center">TD</th>
                         <th class="pb-5 text-center">BMI</th>
                         <th class="pb-5 text-center">Status</th>
                     </tr>
                 </thead>
                 <tbody class="font-bold text-slate-700">
                     @foreach($atensi as $p)
                     <td class="py-5">
    <!-- Link ke Riwayat Individu -->
    <a href="{{ url('/anggota/'.$p->user->id.'/riwayat') }}" class="group block">
        <p class="text-blue-900 leading-tight uppercase group-hover:text-blue-600 group-hover:underline transition font-black">
            {{ $p->user->nama_lengkap }}
        </p>
        <p class="text-[8px] text-slate-300 font-normal uppercase mt-1">
            NRP: {{ $p->user->nrp }} — <span class="text-blue-400">Lihat Sejarah →</span>
        </p>
    </a>
</td>
                         
                         <!-- BMI DENGAN LABEL DINAMIS & EFEK PULSE -->
                         <td class="text-center">
                            @if($p->bmi >= 30)
                                <p class="text-red-600 font-black animate-pulse text-sm">{{ $p->bmi }}</p>
                                <p class="text-[7px] text-red-500 uppercase">Obesitas</p>
                            @elseif($p->bmi >= 25)
                                <p class="text-orange-500 font-black text-sm">{{ $p->bmi }}</p>
                                <p class="text-[7px] text-orange-400 uppercase">Overweight</p>
                            @elseif($p->bmi < 18.5)
                                <p class="text-blue-400 font-black text-sm">{{ $p->bmi }}</p>
                                <p class="text-[7px] text-blue-300 uppercase">Underweight</p>
                            @else
                                <p class="text-green-600 font-black text-sm">{{ $p->bmi }}</p>
                                <p class="text-[7px] text-green-400 uppercase">Ideal</p>
                            @endif
                         </td>

                         <td class="text-center">
                             <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter {{ $p->status_kelayakan == 'Memenuhi Syarat' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100 animate-pulse' }}">
                                 {{ $p->status_kelayakan == 'Memenuhi Syarat' ? 'MS' : 'TMS' }}
                             </span>
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
        </div>
    </div>

    <!-- KOLOM KANAN: DISTRIBUSI BMI -->
    <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 text-center">Distribusi BMI</h4>
        <div class="space-y-6">
            @php 
                $bmi_bars = [
                    ['l' => 'Underweight', 'v' => $kurus, 'c' => 'bg-blue-400'],
                    ['l' => 'Normal', 'v' => $ideal, 'c' => 'bg-green-500'],
                    ['l' => 'Overweight', 'v' => $overweight, 'c' => 'bg-orange-400'],
                    ['l' => 'Obesitas', 'v' => $obesitas, 'c' => 'bg-red-600 animate-pulse']
                ]; 
            @endphp
            @foreach($bmi_bars as $b)
            <div>
                <div class="flex justify-between text-[9px] font-black mb-2 uppercase tracking-widest">
                    <span class="text-slate-500">{{ $b['l'] }}</span>
                    <span class="text-slate-900">{{ $b['v'] }} ORG</span>
                </div>
                <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                    <div class="h-full {{ $b['c'] }} rounded-full transition-all duration-1000 shadow-sm" style="width: {{ ($total_periksa > 0) ? ($b['v'] / $total_periksa) * 100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection