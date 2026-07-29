<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Kesamaptaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0F172A] flex min-h-screen">

    <!-- SISI KIRI: VISUAL & STATISTIK -->
    <div class="hidden lg:flex lg:w-2/3 p-16 flex-col justify-between relative overflow-hidden">
        <!-- Dot Pattern Background -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-16">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                    <img src="{{ asset('img/logo-polri.png') }}" class="w-8">
                </div>
                <div>
                    <p class="text-white text-[10px] font-black uppercase tracking-[0.3em] leading-none">Polres Kota</p>
                    <p class="text-slate-400 text-[12px] font-bold">E-Kesamaptaan</p>
                </div>
            </div>

            <h1 class="text-white text-7xl font-black uppercase tracking-tighter leading-[0.9]">
                Sistem <br> Informasi <br> <span class="text-yellow-500">Kesehatan</span> <br> Anggota Polri
            </h1>
            <p class="text-slate-400 mt-8 max-w-lg text-sm font-semibold leading-relaxed">
                Platform pengelolaan data kesamaptaan jasmani — mendukung keputusan bertugas atau rehabilitasi secara akurat dan terstruktur.
            </p>
        </div>

        <!-- Mini Statistik Bawah -->
        <div class="grid grid-cols-2 gap-8 relative z-10">
            <div class="bg-slate-800/40 backdrop-blur-md p-6 rounded-2xl border border-white/5">
                <p class="text-yellow-500 text-3xl font-black italic">248</p>
                <p class="text-slate-500 text-[10px] font-black uppercase mt-1 tracking-widest">Anggota Terdaftar</p>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-md p-6 rounded-2xl border border-white/5">
                <p class="text-green-500 text-3xl font-black italic">89%</p>
                <p class="text-slate-500 text-[10px] font-black uppercase mt-1 tracking-widest">Siap Bertugas</p>
            </div>
        </div>
        
        <p class="text-slate-600 text-[10px] font-bold relative z-10 italic">© 2026 Polres Kota • E-Kesamaptaan v2.1</p>
    </div>

    <!-- SISI KANAN: FORM LOGIN -->
    <div class="w-full lg:w-1/3 bg-slate-50 flex items-center justify-center p-10">
        <div class="w-full max-w-sm">
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Masuk ke Sistem</h2>
                <p class="text-slate-400 text-xs font-bold mt-1">Gunakan akun yang diberikan administrator</p>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-white">
                <form action="{{ url('/login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-6">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">NRP Personil</label>
                        <input type="text" name="nrp" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-900 outline-none transition" placeholder="Masukkan NRP">
                    </div>

                    <div class="mb-8">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 block">Password</label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-900 outline-none transition" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-[#0F172A] hover:bg-black text-white font-black py-4 rounded-xl shadow-xl transition-all active:scale-95 text-xs uppercase tracking-[0.2em]">
                        Masuk Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>