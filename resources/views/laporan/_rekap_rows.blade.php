@foreach($data as $row)
@php
    $m = $row->medis->first();
    $s = $row->samaptas->first();
@endphp
<tr class="table-row border-b border-slate-50 last:border-0 hover:bg-slate-50/30 transition">
    <td class="px-10 py-6">
        <a href="{{ url('/anggota/'.$row->id.'/riwayat') }}" class="group block">
            <p class="text-blue-900 text-sm font-black uppercase group-hover:underline">{{ $row->nama_lengkap }}</p>
            <p class="text-slate-400 text-[9px] uppercase">{{ $row->pangkat }} — {{ $row->nrp }}</p>
            @if($row->satker)
                <p class="text-slate-300 text-[8px] uppercase mt-1">{{ $row->satker }}</p>
            @endif
        </a>
    </td>
    <td class="px-6 py-6 text-center text-slate-600 text-xs">
        {{ $m ? $m->tensi_sistolik.'/'.$m->tensi_diastolik : 'Belum Ada' }}
    </td>
    <td class="px-6 py-6 text-center">
        <span class="{{ ($m && $m->bmi >= 30) ? 'text-red-600 animate-pulse font-black' : ($m && $m->bmi >= 25 ? 'text-orange-500' : 'text-blue-600') }}">
            {{ $m ? $m->bmi : '-' }}
        </span>
    </td>
    <td class="px-6 py-6 text-center">
        @if($m)
            <span class="text-[9px] uppercase {{ $m->status_kelayakan == 'Memenuhi Syarat' ? 'text-green-600' : 'text-red-600' }}">
                {{ $m->status_kelayakan }}
            </span>
        @else
            <span class="text-slate-200 text-[9px]">N/A</span>
        @endif
    </td>
    <td class="px-6 py-6 text-center text-2xl font-black text-blue-900 italic">
        {{ $s ? $s->nilai_akhir : '-' }}
    </td>
</tr>
@endforeach

@if($data->isEmpty())
<tr>
    <td colspan="5" class="px-10 py-12 text-center text-slate-400 text-xs font-bold uppercase">
        Belum ada data personil.
    </td>
</tr>
@endif
