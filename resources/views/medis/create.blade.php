@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header Form -->
    <div class="flex items-center gap-4">
        <a href="{{ url('/medis') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-900 hover:border-blue-900 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Input Pemeriksaan</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Entry Data Kesehatan Baru</p>
        </div>
    </div>

    <!-- Card Form Utama -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-12">
            <form action="{{ url('/medis/store') }}" method="POST">
                {{ csrf_field() }}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <!-- SISI KIRI: DATA PERSONIL -->
                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3 text-center md:text-left">Pilih Anggota Polri</label>
                            <select name="user_id" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-900 outline-none transition">
                                <option value="">-- Cari Nama / NRP --</option>
                                @foreach($personil as $p)
                                    <option value="{{ $p->id }}">{{ $p->nrp }} — {{ $p->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">TD Sistolik</label>
                                <input type="number" name="tensi_sistolik" placeholder="120" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">TD Diastolik</label>
                                <input type="number" name="tensi_diastolik" placeholder="80" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Status Kelayakan</label>
                            <select name="status_kelayakan" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                                <option value="Memenuhi Syarat">MEMENUHI SYARAT (MS)</option>
                                <option value="Tidak Memenuhi Syarat">TIDAK MEMENUHI SYARAT (TMS)</option>
                            </select>
                        </div>
                    </div>

                    <!-- SISI KANAN: ANTROPOMETRI & BMI -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Tinggi (cm)</label>
                                <input type="number" id="tb" name="tinggi_badan" step="0.1" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 px-1">Berat (kg)</label>
                                <input type="number" id="bb" name="berat_badan" step="0.1" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-blue-900 transition">
                            </div>
                        </div>

                        <!-- HASIL BMI (Visualized) -->
                        <div class="bg-blue-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/20">
                            <p class="text-[9px] font-black text-blue-300 uppercase tracking-widest mb-1 relative z-10">Body Mass Index (BMI)</p>
                            <input type="text" id="bmi" name="bmi" readonly class="bg-transparent border-none p-0 text-5xl font-black italic outline-none relative z-10 w-full" value="0.00">
                            <p id="keterangan_bmi" class="text-[10px] font-bold uppercase mt-2 relative z-10 opacity-70 italic">Menunggu Input...</p>
                            
                            <!-- Watermark di dalam box BMI -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 absolute right-[-10px] bottom-[-10px] opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-12 pt-8 border-t border-slate-50">
                    <button type="submit" class="w-full bg-[#0F172A] hover:bg-black text-white font-black py-5 rounded-[1.5rem] shadow-2xl transition-all active:scale-[0.98] text-xs uppercase tracking-[0.2em]">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const tbInput = document.getElementById('tb');
    const bbInput = document.getElementById('bb');
    const bmiInput = document.getElementById('bmi');
    const ketBmi = document.getElementById('keterangan_bmi');

    function hitungBMI() {
        let tb = tbInput.value / 100;
        let bb = bbInput.value;
        if(tb > 0 && bb > 0) {
            let bmi = (bb / (tb * tb)).toFixed(2);
            bmiInput.value = bmi;
            if(bmi < 18.5) { ketBmi.innerText = "Status: Kurus / Underweight"; }
            else if(bmi <= 25) { ketBmi.innerText = "Status: Normal / Ideal"; }
            else if(bmi <= 30) { ketBmi.innerText = "Status: Overweight"; }
            else { ketBmi.innerText = "Status: Obesitas"; }
        }
    }
    tbInput.addEventListener('input', hitungBMI);
    bbInput.addEventListener('input', hitungBMI);
</script>
@endsection