@extends('layouts.app')

@section('content')
<!-- Container Utama Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- ================= KOLOM KIRI (LEBAR: 2/3) ================= -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Judul Dashboard -->
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Panel Medis & Urkes</h2>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Pusat Kendali Kesehatan Personil</p>
        </div>

        <!-- 1. KOTAK PERINGATAN MERAH (KRITIS) -->
        <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-[2.5rem] p-8 shadow-xl shadow-red-200 text-white relative overflow-hidden">
            <div class="flex justify-between items-center mb-6 relative z-10">
                <h4 class="font-black uppercase tracking-[0.2em] text-[10px] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    Peringatan Medis
                </h4>
                <span class="bg-white/20 backdrop-blur-md px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">
                    {{ count($kritis) }} Anggota Perlu Atensi
                </span>
            </div>
            
            <div class="space-y-4 relative z-10">
                @foreach($kritis as $k)
                <div class="bg-white rounded-[1.5rem] p-5 text-slate-800 flex justify-between items-center shadow-lg transition hover:scale-[1.01]">
                    <div>
                        <p class="font-black text-base uppercase leading-tight text-blue-900">{{ $k->user->nama_lengkap }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $k->user->pangkat }} — {{ $k->user->nrp }}</p>
                        <div class="flex gap-2 mt-3">
                            @if($k->tensi_sistolik >= 140)
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-[8px] font-black uppercase">Hipertensi</span>
                            @endif
                            @if($k->bmi >= 27)
                                <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-lg text-[8px] font-black uppercase">Obesitas</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right border-l-2 border-slate-50 pl-6">
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Tensi Darah</p>
                        <p class="text-2xl font-black text-red-600 leading-none">{{ $k->tensi_sistolik }}/{{ $k->tensi_diastolik }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <img src="{{ asset('img/logo-polri.png') }}" class="absolute right-[-20px] bottom-[-20px] w-48 opacity-10 pointer-events-none filter brightness-0 invert">
        </div>

        <!-- 2. TABEL PEMERIKSAAN TERBARU -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
             <div class="flex justify-between items-center mb-8">
                 <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pemeriksaan Terbaru</h4>
                 <a href="{{ url('/medis') }}" class="text-[9px] font-black text-blue-600 uppercase hover:underline tracking-widest">Kelola Semua Data →</a>
             </div>
             <div class="overflow-x-auto">
                 <table class="w-full text-left text-xs">
                     <thead class="text-slate-400 uppercase font-black tracking-widest border-b border-slate-50">
                         <tr>
                             <th class="pb-5">Anggota</th>
                             <th class="pb-5 text-center">TD</th>
                             <th class="pb-5 text-center">BMI</th>
                             <th class="pb-5 text-center">Status</th>
                         </tr>
                     </thead>
                     <tbody class="font-bold text-slate-700">
                         @foreach($atensi as $p)
                         <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                             <td class="py-5">
                                 <p class="text-blue-900">{{ $p->user->nama_lengkap }}</p>
                                 <p class="text-[9px] text-slate-400 font-normal uppercase">{{ $p->user->pangkat }}</p>
                             </td>
                             <td class="text-center text-slate-500 font-medium">{{ $p->tensi_sistolik }}/{{ $p->tensi_diastolik }}</td>
                             <td class="text-center">
                                 <span class="{{ $p->bmi > 25 ? 'text-orange-500' : 'text-blue-600' }}">{{ $p->bmi }}</span>
                             </td>
                             <td class="text-center">
                                 <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter {{ $p->status_kelayakan == 'Memenuhi Syarat' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                     {{ $p->status_kelayakan == 'Memenuhi Syarat' ? 'Siap Bertugas' : 'TMS' }}
                                 </span>
                             </td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
        </div>
    </div>

    <!-- ================= KOLOM KANAN (KECIL: 1/3) ================= -->
    <div class="space-y-8">
        <!-- 3. DISTRIBUSI BMI (BARS) -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 text-center">Distribusi BMI</h4>
            
            <div class="space-y-7">
                @php 
                    $bmi_data = [
                        ['l' => 'Underweight', 'v' => $kurus, 'c' => 'bg-blue-400'],
                        ['l' => 'Normal', 'v' => $ideal, 'c' => 'bg-green-500'],
                        ['l' => 'Overweight', 'v' => $overweight, 'c' => 'bg-yellow-500'],
                        ['l' => 'Obesitas', 'v' => $obesitas, 'c' => 'bg-red-500']
                    ]; 
                @endphp
                
                @foreach($bmi_data as $b)
                <div>
                    <div class="flex justify-between text-[9px] font-black mb-2 uppercase tracking-widest">
                        <span class="text-slate-500">{{ $b['l'] }}</span>
                        <span class="text-slate-900">{{ $b['v'] }} ORG</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full {{ $b['c'] }} rounded-full transition-all duration-1000 shadow-sm" 
                             style="width: {{ ($total_periksa > 0) ? ($b['v'] / $total_periksa) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Action -->
            <div class="mt-14 space-y-3">
                <a href="{{ url('/medis/create') }}" class="flex items-center justify-center w-full bg-blue-900 hover:bg-black text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-900/10 transition-all active:scale-95 text-[10px] uppercase tracking-widest gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                    Input Medis Baru
                </a>
                <p class="text-[8px] text-center text-slate-400 font-bold uppercase tracking-widest italic">Pembaruan data real-time</p>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="bg-blue-50/50 p-8 rounded-[2.5rem] border border-blue-100/50">
            <h5 class="text-[9px] font-black text-blue-900 uppercase tracking-widest mb-3 italic">Catatan Urkes:</h5>
            <p class="text-[10px] text-blue-800/70 leading-relaxed font-medium">Personil dengan status **Rehabilitasi** atau **TMS** otomatis akan dipantau oleh pimpinan melalui Dashboard Peta Komando.</p>
        </div>
    </div>

</div>
@endsection