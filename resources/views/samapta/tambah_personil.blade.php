@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ url('/dashboard') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-900 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Pengajuan Personil Baru</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">Data akan dikirim ke Kapolres untuk verifikasi</p>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-12">
            <form action="{{ url('/pengajuan/ajukan') }}" method="POST">
                {{ csrf_field() }}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" placeholder="Bripda Pratama" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">NRP</label>
                            <input type="text" name="nrp" placeholder="95010101" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Pangkat</label>
                            <input type="text" name="pangkat" placeholder="Bripda" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Satuan Kerja</label>
                            <select name="satker" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                                <option value="Sat Reskrim">Sat Reskrim</option>
                                <option value="Sat Lantas">Sat Lantas</option>
                                <option value="Sat Sabhara">Sat Sabhara</option>
                                <option value="Sat Intelkam">Sat Intelkam</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-slate-50">
                    <button type="submit" class="w-full bg-[#0F172A] hover:bg-black text-white font-black py-5 rounded-[1.5rem] shadow-2xl transition-all active:scale-[0.98] text-[10px] uppercase tracking-[0.2em]">
                        Kirim Pengajuan ke Kapolres
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection