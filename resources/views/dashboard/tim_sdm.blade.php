@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- KOLOM KIRI (LEBAR): BANNER & TABEL -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- BANNER AKSI SDM -->
        <div class="bg-gradient-to-r from-[#0F172A] to-blue-900 rounded-[2.5rem] p-10 shadow-2xl text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.4em] mb-3 text-blue-400">Bagian SDM & Psikologi</p>
                <h3 class="text-4xl font-black italic uppercase tracking-tighter leading-none">Kelola Nilai <br> Kesamaptaan</h3>
                <p class="text-slate-400 text-xs mt-4 max-w-xs font-medium leading-relaxed">Pastikan anggota dalam status "MS" medis sebelum melanjutkan tes jasmani.</p>
                
                <div class="flex gap-4 mt-8">
                    <a href="{{ url('/samapta/create') }}" class="bg-yellow-500 hover:bg-white text-slate-900 font-black px-8 py-4 rounded-2xl text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95">
                        Input Nilai Baru
                    </a>
                    <a href="{{ url('/laporan/rekap') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-black px-8 py-4 rounded-2xl text-[10px] uppercase tracking-widest transition-all">
                        Database Rekap
                    </a>
                </div>
            </div>
            <img src="{{ asset('img/logo-polri.png') }}" class="absolute right-[-40px] bottom-[-40px] w-80 opacity-5 pointer-events-none filter brightness-0 invert">
        </div>

        <!-- TABEL HASIL TERBARU -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
             <div class="flex justify-between items-center mb-8">
                 <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Update Nilai Jasmani</h4>
                 <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest italic">Periode: {{ date('Y') }}</span>
             </div>
             <table class="w-full text-left text-xs">
                 <thead class="text-slate-400 font-black border-b border-slate-50 uppercase tracking-widest">
                     <tr>
                         <th class="pb-6">Personil</th>
                         <th class="pb-6 text-center">Lari</th>
                         <th class="pb-6 text-center">Final Score</th>
                         <th class="pb-6 text-right">Aksi</th>
                     </tr>
                 </thead>
                 <tbody class="font-bold text-slate-700">
                     @foreach(\App\Samapta::with('user')->latest()->take(5)->get() as $s)
                     <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition group">
                         <td class="py-6">
                             <p class="text-blue-900 text-sm group-hover:text-blue-600 transition">{{ $s->user->nama_lengkap }}</p>
                             <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter">{{ $s->user->pangkat }} — {{ $s->user->nrp }}</p>
                         </td>
                         <td class="text-center text-slate-400 font-medium">{{ $s->lari_meter }}m</td>
                         <td class="text-center">
                             <span class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s->nilai_akhir }}</span>
                         </td>
                         <td class="text-right">
                            <a href="{{ url('/laporan/rekap') }}" class="text-[9px] font-black text-blue-600 hover:underline tracking-widest uppercase">Detail</a>
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
        </div>
    </div>

    <!-- KOLOM KANAN (STATISTIK): DISTRIBUSI PANGKAT -->
    <div class="space-y-8">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 text-center">Distribusi Kepangkatan</h4>
            <div class="space-y-8">
                @php 
                    $ranks = [
                        ['l' => 'Pama (AKP/Iptu/Ipda)', 'p' => 15, 'c' => 'bg-slate-900'],
                        ['l' => 'Bintara Tinggi (Aipda)', 'p' => 35, 'c' => 'bg-blue-800'],
                        ['l' => 'Bintara (Bripka/Brigpol)', 'p' => 65, 'c' => 'bg-blue-600'],
                        ['l' => 'Tamtama/Bripda', 'p' => 85, 'c' => 'bg-blue-400']
                    ]; 
                @endphp
                @foreach($ranks as $rk)
                <div>
                    <div class="flex justify-between text-[10px] font-black uppercase mb-3 tracking-widest">
                        <span class="text-slate-500">{{ $rk['l'] }}</span>
                        <span class="text-slate-900">{{ $rk['p'] }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full {{ $rk['c'] }} rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $rk['p'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Overall HR Status -->
            <div class="mt-16 bg-slate-50 p-8 rounded-[2rem] border border-slate-100 text-center">
                <p class="text-[10px] font-black text-blue-900 uppercase tracking-[0.3em] mb-2">Record Integrity</p>
                <p class="text-4xl font-black text-slate-800 tracking-tighter leading-none">100%</p>
                <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase italic">Data Terintegrasi</p>
            </div>
        </div>
    </div>
</div>
@endsection