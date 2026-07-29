<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kesamaptaan v2.1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-active { background: #EAB308; color: #000; border-radius: 8px; }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <!-- SIDEBAR (Reference Style) -->
    <aside class="w-64 bg-[#0F172A] text-slate-400 flex flex-col fixed h-full z-50">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <img src="{{ asset('img/logo-polri.png') }}" class="w-8">
            <div class="leading-tight">
                <p class="text-white text-xs font-black uppercase">POLRES KOTA</p>
                <p class="text-[10px] font-bold">E-Kesamaptaan</p>
            </div>
        </div>

        <nav class="p-4 flex-1 space-y-2">
            <p class="text-[10px] font-bold text-slate-500 uppercase px-4 mb-2">Main Menu</p>
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition {{ Request::is('dashboard') ? 'sidebar-active text-slate-900' : '' }}">
                <span>Dashboard</span>
            </a>
            
            @if(Auth::user()->role == 'admin_urkes')
                <a href="{{ url('/medis') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition">Panel Medis</a>
            @endif

            @if(Auth::user()->role == 'tim_sdm')
                <a href="{{ url('/samapta') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition {{ Request::is('samapta*') ? 'sidebar-active text-slate-900' : '' }}">
                <span>Kelola Personil</span>
                </a>
            @endif

            <a href="{{ url('/laporan/rekap') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition">Laporan</a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <div class="bg-slate-800/50 p-3 rounded-xl flex items-center gap-3">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-slate-900 font-bold text-xs">
                    {{ substr(Auth::user()->nama_lengkap, 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-[10px] font-bold truncate">{{ Auth::user()->nama_lengkap }}</p>
                    <p class="text-[9px] uppercase tracking-tighter">{{ Auth::user()->pangkat }}</p>
                </div>
            </div>
            <form action="{{ url('/logout') }}" method="POST" class="mt-2">
                {{ csrf_field() }}
                <button class="w-full text-[10px] font-bold text-red-400 hover:text-red-300 py-2 text-left px-3">LOGOUT SYSTEM</button>
            </form>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <div class="flex-1 ml-64">
        <!-- TOPBAR -->
        <header class="h-16 bg-white border-b flex items-center justify-between px-8 sticky top-0 z-40">
            <h2 class="font-bold text-slate-800 uppercase text-sm tracking-widest">Peta Komando</h2>
            <div class="flex items-center gap-4">
                <p class="text-xs font-bold text-slate-400">{{ date('D, d M Y') }}</p>
                <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center font-bold text-[10px] text-slate-600">
                    {{ Auth::user()->role == 'kapolres' ? 'KP' : 'SD' }}
                </div>
            </div>
        </header>

        <main class="p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>