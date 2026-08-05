<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kesamaptaan v2.1 | Polres Mojokerto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-active { background: #EAB308; color: #000 !important; border-radius: 12px; shadow: 0 10px 15px -3px rgba(234, 179, 8, 0.3); }
        .sidebar-active svg { color: #000 !important; }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <!-- ================= SIDEBAR (Dark Navy Style) ================= -->
    <aside class="w-72 bg-[#0F172A] text-slate-400 flex flex-col fixed h-full z-50 shadow-2xl">
        <!-- Logo Section -->
        <div class="p-8 flex items-center gap-4 border-b border-slate-800/50">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                <img src="{{ asset('img/logo-polri.png') }}" class="w-7">
            </div>
            <div class="leading-tight">
                <p class="text-white text-xs font-black uppercase tracking-widest">Polres Mojokerto</p>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">E-Kesamaptaan v2.1</p>
            </div>
        </div>

        <!-- Menu Section -->
        <nav class="p-4 flex-1 space-y-2 mt-4 overflow-y-auto">
            <p class="text-[10px] font-black text-slate-600 uppercase px-4 mb-4 tracking-[0.2em]">Main Navigation</p>
            
            <!-- 1. DASHBOARD -->
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('dashboard') ? 'sidebar-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                <span>Dashboard</span>
            </a>

            <!-- 2. MENU KAPOLRES (APPROVAL) -->
            @if(Auth::user()->role == 'kapolres')
                @php $pending = \App\Pengajuan::where('status', 'PENDING')->count(); @endphp
                <a href="{{ url('/pengajuan/persetujuan') }}" class="flex items-center justify-between p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('pengajuan*') ? 'sidebar-active' : '' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <span>Persetujuan Data</span>
                    </div>
                    @if($pending > 0)
                        <span class="bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-lg shadow-red-900/50">{{ $pending }}</span>
                    @endif
                </a>
            @endif

            <!-- 3. MENU SDM (DATABASE & NILAI) -->
            @if(Auth::user()->role == 'tim_sdm')
                <!-- Menu Database Anggota (Aktif jika URL mengandung kata 'anggota') -->
                <a href="{{ url('/anggota') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('anggota*') ? 'sidebar-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span>Database Anggota</span>
                </a>

                <!-- Menu Nilai Samapta (Aktif jika URL mengandung kata 'samapta') -->
                <a href="{{ url('/samapta') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('samapta*') ? 'sidebar-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    <span>Nilai Samapta</span>
                </a>
            @endif

            <!-- 4. MENU URKES -->
            @if(Auth::user()->role == 'admin_urkes')
                <a href="{{ url('/medis') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('medis*') ? 'sidebar-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    <span>Panel Medis</span>
                </a>
            @endif

            <!-- 5. LAPORAN GLOBAL (Semua User) -->
            <a href="{{ url('/laporan/rekap') }}" class="flex items-center gap-3 p-3 text-sm font-semibold hover:text-white transition group {{ Request::is('laporan*') ? 'sidebar-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5m14 0h-2a4 4 0 00-4 4v2m-3-4h.01M9 16h.01" /></svg>
                <span>Laporan Global</span>
            </a>
        </nav>

        <!-- User Profile Section -->
        <div class="p-6 border-t border-slate-800/50">
            <div class="bg-slate-800/40 p-4 rounded-[1.5rem] flex items-center gap-3 border border-white/5">
                <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center text-[#0F172A] font-black shadow-lg">
                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white text-[11px] font-black uppercase truncate">{{ Auth::user()->nama_lengkap }}</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form action="{{ url('/logout') }}" method="POST" class="mt-4">
                {{ csrf_field() }}
                <button class="w-full text-center text-[10px] font-black text-red-400/70 hover:text-red-400 uppercase tracking-[0.2em] py-2 transition-all">LOGOUT SYSTEM</button>
            </form>
        </div>
    </aside>

    <!-- ================= CONTENT AREA ================= -->
    <div class="flex-1 ml-72">
        <!-- Topbar -->
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-6 bg-blue-900 rounded-full"></div>
                <h2 class="font-black text-slate-800 uppercase text-xs tracking-[0.2em]">Peta Komando Digital</h2>
            </div>
            <div class="flex items-center gap-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ date('l, d F Y') }}</p>
                <div class="w-10 h-10 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center font-black text-[10px] text-blue-900">
                    {{ Auth::user()->role == 'kapolres' ? 'KP' : 'ST' }}
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-10">
            @yield('content')
        </main>

        <!-- Footer Footer -->
        <footer class="p-10 text-center text-[9px] font-bold text-slate-300 uppercase tracking-[0.5em]">
            &copy; 2026 Tim IT Polres Mojokerto — E-Kesamaptaan v2.1
        </footer>
    </div>

</body>
</html>