@extends('layouts.app')

@section('content')

<!-- 1. NOTIFIKASI FLASH MESSAGE (PREMIUM TOAST) -->
@if(session('success'))
<div id="alert-success" class="mb-8 flex items-center justify-between p-6 bg-green-600 text-white rounded-[2.5rem] shadow-2xl animate-fade-in-down">
    <div class="flex items-center gap-5">
        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center font-black">✓</div>
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Konfirmasi Sistem</p>
            <p class="font-bold text-sm leading-tight">{{ session('success') }}</p>
        </div>
    </div>
    <button onclick="document.getElementById('alert-success').remove()" class="opacity-50 hover:opacity-100 p-2">✕</button>
</div>

<script>
    setTimeout(function() {
        const alert = document.getElementById('alert-success');
        if(alert) {
            alert.style.transition = "all 0.5s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-20px)";
            setTimeout(() => alert.remove(), 500);
        }
    }, 6000);
</script>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    
    <!-- ================= KOLOM KIRI (UTAMA) ================= -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- BANNER AKSI STRATEGIS -->
        <div class="bg-gradient-to-r from-[#0F172A] to-blue-900 rounded-[2.5rem] p-10 shadow-2xl text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.4em] mb-3 text-blue-400">Bagian SDM & Psikologi</p>
                <h3 class="text-4xl font-black italic uppercase tracking-tighter leading-none text-white">Kelola Nilai <br> Kesamaptaan</h3>
                <p class="text-slate-400 text-xs mt-4 max-w-xs font-medium leading-relaxed opacity-80 italic">"Integritas data jasmani mendukung kesiapan operasional Polri."</p>
                
                <div class="flex flex-wrap gap-4 mt-10">
                    <a href="{{ url('/samapta/create') }}" class="bg-yellow-500 hover:bg-white text-slate-900 font-black px-8 py-4 rounded-2xl text-[10px] uppercase tracking-widest transition-all shadow-xl active:scale-95">
                        Input Nilai Baru
                    </a>
                    <a href="{{ url('/anggota/tambah-personil') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/20 font-black px-8 py-4 rounded-2xl text-[10px] uppercase tracking-widest transition-all active:scale-95">
                        + Ajukan Anggota
                    </a>
                </div>
            </div>
            <img src="{{ asset('img/logo-polri.png') }}" class="absolute right-[-40px] bottom-[-40px] w-80 opacity-10 pointer-events-none filter brightness-0 invert">
        </div>

        <!-- TABEL HASIL TERBARU -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-10">
             <div class="flex justify-between items-center mb-8">
                 <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Update Nilai Terakhir</h4>
                 <a href="{{ url('/samapta') }}" class="text-[9px] font-black text-blue-600 uppercase hover:underline tracking-widest">Database Lengkap →</a>
             </div>
             <table class="w-full text-left text-xs">
                 <thead class="text-slate-400 font-black border-b border-slate-50 uppercase">
                     <tr>
                         <th class="pb-6">Personil</th>
                         <th class="pb-6 text-center">Lari</th>
                         <th class="pb-6 text-center">Score</th>
                     </tr>
                 </thead>
                 <tbody class="font-bold text-slate-700">
                     @foreach(\App\Samapta::with('user')->latest()->take(5)->get() as $s)
                     <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition">
                         <td class="py-6">
                             <p class="text-blue-900 text-sm leading-tight">{{ $s->user->nama_lengkap }}</p>
                             <p class="text-[9px] text-slate-400 font-medium uppercase mt-1">{{ $s->user->nrp }}</p>
                         </td>
                         <td class="text-center text-slate-400 font-medium italic">{{ $s->lari_meter }}m</td>
                         <td class="text-center">
                             <span class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s->nilai_akhir }}</span>
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
        </div>
    </div>

    <!-- ================= KOLOM KANAN (MONITORING) ================= -->
    <div class="space-y-8">
        
        <!-- KARTU STATUS PENGAJUAN (RINGKASAN DENGAN JAM) -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100 transition hover:shadow-md">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Status Pengajuan</h4>
            
            <div class="space-y-4">
                @php $history = \App\Pengajuan::latest()->take(3)->get(); @endphp
                @forelse($history as $h)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-blue-900 font-black uppercase text-[10px] truncate leading-none">{{ $h->nama_lengkap }}</p>
                    <div class="flex justify-between items-center mt-2.5">
                        <!-- JAM PENGAJUAN RINGKAS -->
                        <p class="text-[7px] text-slate-400 font-bold uppercase">{{ $h->created_at->format('d/m • H:i') }} WIB</p>
                        
                        <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded-lg
                            {{ $h->status == 'DISETUJUI' ? 'bg-green-100 text-green-600' : ($h->status == 'DITOLAK' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600 animate-pulse') }}">
                            {{ $h->status }}
                        </span>
                    </div>
                </div>
                @empty
                    <p class="text-center text-slate-300 text-[10px] font-bold py-4">BELUM ADA DATA</p>
                @endforelse
            </div>

            <!-- TOMBOL UNTUK MEMBUKA MODAL -->
            <div class="mt-8 pt-6 border-t border-slate-50 text-center">
                <button onclick="toggleModal('modal-all-notif')" class="w-full bg-[#0F172A] hover:bg-black text-white font-black py-3 rounded-2xl text-[9px] uppercase tracking-widest transition-all shadow-lg active:scale-95">
                    Lihat Semua Riwayat →
                </button>
            </div>
        </div>

        <!-- DISTRIBUSI PANGKAT -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 text-center">Pangkat Anggota</h4>
            <div class="space-y-6">
                @php $ranks = [['l' => 'Pama', 'p' => 15, 'c' => 'bg-slate-900'], ['l' => 'Bintara Tinggi', 'p' => 35, 'c' => 'bg-blue-800'], ['l' => 'Bintara', 'p' => 65, 'c' => 'bg-blue-600'], ['l' => 'Tamtama', 'p' => 85, 'c' => 'bg-blue-400']]; @endphp
                @foreach($ranks as $rk)
                <div>
                    <div class="flex justify-between text-[9px] font-black mb-1.5 uppercase tracking-widest">
                        <span class="text-slate-500">{{ $rk['l'] }}</span>
                        <span class="text-slate-900">{{ $rk['p'] }}%</span>
                    </div>
                    <div class="w-full h-1 bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full {{ $rk['c'] }} rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $rk['p'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
    MODAL OVERLAY (DAFTAR PENGAJUAN LENGKAP DENGAN TANGGAL & JAM)
========================================================================= -->
<div id="modal-all-notif" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-[#0F172A]/90 backdrop-blur-md">
    <div class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden animate-fade-in-up">
        
        <!-- Header Modal -->
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div>
                <h3 class="text-2xl font-black text-blue-900 uppercase tracking-tighter leading-none">Riwayat Pengajuan</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2">Daftar Lengkap Verifikasi Kapolres</p>
            </div>
            <button onclick="toggleModal('modal-all-notif')" class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-red-500 transition shadow-sm">✕</button>
        </div>

        <!-- Body Modal (DENGAN TANGGAL & JAM REAL-TIME) -->
        <div class="p-10 max-h-[50vh] overflow-y-auto custom-scrollbar space-y-4 bg-slate-50/30">
            @foreach(\App\Pengajuan::latest()->get() as $all)
            <div class="flex justify-between items-center p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition hover:scale-[1.01]">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-900 text-white rounded-full flex items-center justify-center font-black text-xs shadow-sm">
                        {{ substr($all->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-blue-900 font-black uppercase text-sm leading-none">{{ $all->nama_lengkap }}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $all->nrp }} — {{ $all->satker }}</p>
                            <span class="text-slate-200 text-[10px]">|</span>
                            <!-- TANGGAL & JAM REAL-TIME DETAIL -->
                            <div class="flex items-center gap-1 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p class="text-[8px] font-black uppercase tracking-tighter">
                                    {{ $all->created_at->format('d M Y') }} • {{ $all->created_at->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border
                        {{ $all->status == 'DISETUJUI' ? 'bg-green-50 text-green-600 border-green-100' : ($all->status == 'DITOLAK' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-yellow-50 text-yellow-600 border-yellow-100') }}">
                        {{ $all->status }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Footer Modal -->
        <div class="p-8 text-center border-t border-slate-50">
            <p class="text-[9px] text-slate-300 font-bold uppercase tracking-[0.2em] italic">Audit Log E-Kesamaptaan Polres v2.1</p>
        </div>
    </div>
</div>

<!-- ================= SCRIPT & STYLE ================= -->
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = 'auto';
        }
    }
</script>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fade-in-up 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

@endsection