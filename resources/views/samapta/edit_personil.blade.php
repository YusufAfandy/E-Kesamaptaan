@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ url('/anggota') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-900 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Ajukan Revisi Data</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">Perubahan data NRP: {{ $user->nrp }}</p>
        </div>
    </div>

    <!-- Form Box -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-12">
            <form action="{{ url('/pengajuan/ajukan-edit/'.$user->id) }}" method="POST">
                {{ csrf_field() }}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Nama Lengkap Baru</label>
                            <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-900 outline-none transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Pangkat</label>
                            <input type="text" name="pangkat" value="{{ $user->pangkat }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Satuan Kerja (Satker)</label>
                            <select name="satker" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                                <option value="Sat Reskrim" {{ $user->satker == 'Sat Reskrim' ? 'selected' : '' }}>Sat Reskrim</option>
                                <option value="Sat Lantas" {{ $user->satker == 'Sat Lantas' ? 'selected' : '' }}>Sat Lantas</option>
                                <option value="Sat Sabhara" {{ $user->satker == 'Sat Sabhara' ? 'selected' : '' }}>Sat Sabhara</option>
                                <option value="Sat Intelkam" {{ $user->satker == 'Sat Intelkam' ? 'selected' : '' }}>Sat Intelkam</option>
                            </select>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 p-6 rounded-[2rem] border border-blue-100">
                            <p class="text-[9px] font-black text-blue-900 uppercase tracking-widest mb-2">Catatan:</p>
                            <p class="text-[10px] text-blue-800/70 leading-relaxed">Setelah Anda klik simpan, data anggota di sistem **tidak langsung berubah**. Anda harus menunggu Kapolres memberikan persetujuan terlebih dahulu.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-50 text-right">
                    <button type="submit" class="w-full bg-[#0F172A] hover:bg-black text-white font-black py-5 rounded-[1.5rem] shadow-2xl transition-all active:scale-[0.98] text-[10px] uppercase tracking-[0.2em]">
                        Kirim Permohonan Perubahan ke Kapolres
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection