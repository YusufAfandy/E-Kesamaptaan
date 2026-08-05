@extends('layouts.app')

@section('content')
<!-- Library Utama untuk Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<div class="space-y-8">
    
    <!-- HEADER & SEARCH BAR -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 no-print">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">Database Rekapitulasi</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 tracking-[0.3em]">Export Data Kesiapan Personil ke Excel</p>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <!-- SEARCH INPUT -->
            <div class="relative w-full md:w-80">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari NRP atau Nama..." 
                    class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-xs font-bold outline-none focus:ring-2 focus:ring-green-600 transition-all shadow-sm">
            </div>

            <!-- TOMBOL EXCEL SINGLE -->
            <button onclick="exportToExcel()" class="bg-green-600 hover:bg-black text-white px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-xl shadow-green-900/20 active:scale-95 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </button>
        </div>
    </div>

    <!-- TABEL REKAPITULASI (ID: reportTable) -->
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="reportTable">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-black text-[10px] uppercase tracking-widest border-b border-slate-100">
                        <th class="px-10 py-8">Nama Lengkap & NRP</th>
                        <th class="px-6 py-8 text-center">Tensi (S/D)</th>
                        <th class="px-6 py-8 text-center">Indeks BMI</th>
                        <th class="px-6 py-8 text-center">Status Medis</th>
                        <th class="px-6 py-8 text-center">Nilai Akhir Jasmani</th>
                    </tr>
                </thead>
                <tbody class="font-bold">
                    @foreach($data as $row)
                    @php 
                        $m = $row->medis->last(); 
                        $s = $row->samaptas->last(); 
                    @endphp
                    <tr class="table-row border-b border-slate-50 last:border-0 hover:bg-slate-50/30 transition">
                        <td class="px-10 py-6">
                            <p class="text-blue-900 text-sm">{{ $row->nama_lengkap }}</p>
                            <p class="text-slate-400 text-[9px] uppercase tracking-tighter">{{ $row->pangkat }} — {{ $row->nrp }}</p>
                        </td>
                        <td class="px-6 py-6 text-center text-slate-600">
                            {{ $m ? $m->tensi_sistolik.'/'.$m->tensi_diastolik : '-' }}
                        </td>
                        <td class="px-6 py-6 text-center">
                            <span class="{{ ($m && $m->bmi >= 30) ? 'text-red-600' : 'text-blue-600' }}">
                                {{ $m ? $m->bmi : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @if($m)
                                <span class="uppercase text-[9px] {{ $m->status_kelayakan == 'Memenuhi Syarat' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $m->status_kelayakan }}
                                </span>
                            @else
                                <span class="text-slate-300 font-normal italic text-[9px]">Belum Periksa</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-center">
                            <p class="text-2xl font-black text-blue-900 italic tracking-tighter">{{ $s ? $s->nilai_akhir : '-' }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // 1. FUNGSI PENCARIAN REAL-TIME
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const tr = document.getElementsByClassName("table-row");
        for (let i = 0; i < tr.length; i++) {
            const content = tr[i].textContent || tr[i].innerText;
            tr[i].style.display = content.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }

    // 2. FUNGSI EXPORT EXCEL DENGAN FORMAT RAPI (TANPA EDIT MANUAL)
    function exportToExcel() {
        const table = document.getElementById("reportTable");
        
        // Buat Worksheet dari Tabel
        const ws = XLSX.utils.table_to_sheet(table);

        // --- PENGATURAN KERAPIHAN (AUTO-WIDTH) ---
        const wscols = [
            { wch: 35 }, // Kolom Nama & NRP (Lebar)
            { wch: 15 }, // Kolom Tensi
            { wch: 15 }, // Kolom BMI
            { wch: 25 }, // Kolom Status Medis
            { wch: 20 }, // Kolom Nilai Jasmani
        ];
        ws['!cols'] = wscols;

        // Buat Workbook
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Rekapitulasi");

        // Nama File: Laporan_Tanggal.xlsx
        const date = new Date().toISOString().slice(0, 10);
        const fileName = "E-Kesamaptaan_Rekap_" + date + ".xlsx";

        // Download File
        XLSX.writeFile(wb, fileName);
    }
</script>

@endsection