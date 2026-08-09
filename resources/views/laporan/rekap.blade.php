@extends('layouts.app')

@section('content')
<!-- Library Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<div class="space-y-8">
    
    <!-- HEADER, SEARCH & EXPORT -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 no-print">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Log Rekapitulasi Global</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Seluruh Riwayat Pemeriksaan (Lama & Baru)</p>
        </div>

        <div class="flex items-center gap-4">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari NRP atau Nama..." 
                class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-xs font-bold outline-none focus:ring-2 focus:ring-green-600 transition shadow-sm w-64">

            <button onclick="exportToExcel()" class="bg-green-600 hover:bg-black text-white px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition shadow-xl active:scale-95 flex items-center gap-2">
                Export Excel
            </button>
        </div>
    </div>

    <!-- TABEL LOG AKTIVITAS -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="reportTable">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-black text-[10px] uppercase border-b border-slate-100">
                        <th class="px-10 py-8 text-center">Tgl Periksa</th>
                        <th class="px-6 py-8">Nama & NRP</th>
                        <th class="px-6 py-8 text-center">TD / BMI</th>
                        <th class="px-6 py-8 text-center">Status</th>
                        <th class="px-6 py-8 text-center">Score Samapta</th>
                    </tr>
                </thead>
                <tbody class="font-bold">
                    @foreach($dataMedis as $m)
                    @php 
                        // Cari data samapta yang miliknya anggota ini di periode yang sama
                        // atau ambil data samapta terbaru milik anggota ini
                        $s = \App\Samapta::where('user_id', $m->user_id)->latest()->first(); 
                    @endphp
                    <tr class="table-row border-b border-slate-50 last:border-0 hover:bg-slate-50/30 transition">
                        <!-- TANGGAL PERIKSA -->
                        <td class="px-10 py-6 text-center text-[11px] text-slate-400">
                            {{ date('d/m/Y', strtotime($m->tanggal_periksa)) }}
                        </td>

                        <!-- DATA PERSONIL -->
                        <td class="px-6 py-6">
                            <a href="{{ url('/anggota/'.$m->user->id.'/riwayat') }}" class="group block">
                                <p class="text-blue-900 text-sm group-hover:text-blue-600 group-hover:underline transition uppercase">{{ $m->user->nama_lengkap }}</p>
                                <p class="text-slate-400 text-[9px] uppercase tracking-tighter">{{ $m->user->pangkat }} — {{ $m->user->nrp }}</p>
                            </a>
                        </td>

                        <!-- DATA MEDIS -->
                        <td class="px-6 py-6 text-center">
                            <p class="text-slate-600 text-xs">{{ $m->tensi_sistolik }}/{{ $m->tensi_diastolik }}</p>
                            <p class="text-[10px] {{ $m->bmi >= 30 ? 'text-red-600 animate-pulse' : 'text-blue-500' }}">BMI: {{ $m->bmi }}</p>
                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-6 text-center">
                            <span class="px-4 py-1.5 rounded-full text-[9px] uppercase tracking-widest {{ $m->status_kelayakan == 'Memenuhi Syarat' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $m->status_kelayakan }}
                            </span>
                        </td>

                        <!-- SCORE SAMAPTA -->
                        <td class="px-6 py-6 text-center">
                            @if($s)
                                <p class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s->nilai_akhir }}</p>
                                <p class="text-[8px] text-slate-300 uppercase">{{ $s->periode }}</p>
                            @else
                                <span class="text-slate-200">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterTable() {
        var input = document.getElementById("searchInput"), filter = input.value.toUpperCase(), tr = document.getElementsByClassName("table-row");
        for (var i = 0; i < tr.length; i++) { tr[i].style.display = tr[i].textContent.toUpperCase().indexOf(filter) > -1 ? "" : "none"; }
    }

    function exportToExcel() {
        var ws = XLSX.utils.table_to_sheet(document.getElementById("reportTable"));
        ws['!cols'] = [{wch:15},{wch:40},{wch:15},{wch:20},{wch:20}];
        var wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, "Log_Rekap");
        XLSX.writeFile(wb, "E-Kesamaptaan_Log_Lengkap.xlsx");
    }
</script>
@endsection