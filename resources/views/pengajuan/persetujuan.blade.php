@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">Persetujuan Per Satuan</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2 tracking-[0.2em]">Verifikasi Berdasarkan Kelompok Fungsi Satker</p>
        </div>
        <span class="bg-blue-900 text-white px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">
            {{ count($data) }} Antrean Global
        </span>
    </div>

    <div class="space-y-4">
        @php $satkers = ['Sat Reskrim', 'Sat Lantas', 'Sat Sabhara', 'Sat Intelkam']; @endphp

        @foreach($satkers as $satker)
            @php $data_per_satker = $data->where('satker', $satker); @endphp

            <details class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden" {{ $data_per_satker->count() > 0 ? 'open' : '' }}>
                <summary class="flex justify-between items-center p-8 cursor-pointer list-none hover:bg-slate-50 transition-all">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-blue-900 text-white shadow-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <div>
                            <h3 class="text-blue-900 font-black text-xl uppercase tracking-tighter">{{ $satker }}</h3>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Fungsi Operasional</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase {{ $data_per_satker->count() > 0 ? 'bg-yellow-500 text-white' : 'bg-slate-100 text-slate-300' }}">
                            {{ $data_per_satker->count() }} PENDING
                        </span>
                        <svg class="h-5 w-5 text-slate-300 group-open:rotate-180 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </summary>

                <div class="p-8 pt-0 space-y-4">
                    <!-- FITUR SETUJUI SEMUA -->
                    @if($data_per_satker->count() > 1)
                    <div class="flex justify-end mb-4 px-2">
                        <form action="{{ url('/pengajuan/setujui-semua/'.$satker) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-900 text-[9px] font-black uppercase tracking-[0.2em] px-5 py-2 rounded-xl transition-all">Setujui Semua {{ $satker }}</button>
                        </form>
                    </div>
                    @endif

                    @forelse($data_per_satker as $p)
                    <div class="bg-slate-50 p-6 rounded-[1.5rem] flex justify-between items-center border border-slate-100 transition hover:bg-white">
                        <div class="flex items-center gap-4">
                             <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-black shadow-sm text-xs">{{ substr($p->nama_lengkap, 0, 1) }}</div>
                             <div>
                                 <div class="flex items-center gap-2">
                                     <p class="text-blue-900 font-black uppercase text-sm leading-none">{{ $p->nama_lengkap }}</p>
                                     <span class="text-slate-300 text-[10px]">•</span>
                                     <!-- TANGGAL JAM REAL-TIME PENGAJUAN -->
                                     <p class="text-[9px] font-black text-blue-600 uppercase tracking-tighter">{{ $p->created_at->format('d/m/Y H:i') }} WIB</p>
                                 </div>
                                 <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">NRP: {{ $p->nrp }} • {{ $p->pangkat }}</p>
                             </div>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ url('/pengajuan/setujui/'.$p->id) }}" method="POST"> {{ csrf_field() }}
                                <button type="submit" class="bg-blue-900 hover:bg-black text-white px-6 py-2 rounded-xl text-[9px] font-black uppercase transition shadow-lg">Setujui</button>
                            </form>
                            <form action="{{ url('/pengajuan/tolak/'.$p->id) }}" method="POST"> {{ csrf_field() }}
                                <button type="submit" class="bg-red-50 text-red-600 px-6 py-2 rounded-xl text-[9px] font-black uppercase border border-red-100 transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                    @empty
                        <p class="text-center text-[10px] font-bold text-slate-300 py-6 uppercase italic">Kosong</p>
                    @endforelse
                </div>
            </details>
        @endforeach
    </div>
</div>
@endsection