<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Urkes | E-Kesamaptaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- NAVBAR -->
    <nav class="bg-blue-900 text-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-xl font-black uppercase tracking-tighter">E-KESAMAPTAAN <span class="font-light text-blue-300">| URKES</span></h1>
        <div class="flex items-center gap-4">
            <span class="text-sm font-bold">{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->pangkat }})</span>
            <form action="{{ url('/logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-2 rounded-lg font-bold transition">LOGOUT</button>
            </form>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="p-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Selamat Datang di Panel Urusan Kesehatan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Input Data Medis -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-8 border-green-500">
                    <h3 class="font-black text-gray-700 uppercase tracking-widest text-sm">Pemeriksaan</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">DATA MEDIS</p>
                    <a href="{{ url('/medis/create') }}" class="inline-block mt-4 text-blue-600 font-bold hover:underline">Mulai Input →</a>
                </div>

                <!-- Card 2: Status Personil -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-8 border-blue-500">
                    <h3 class="font-black text-gray-700 uppercase tracking-widest text-sm">Monitoring</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">HASIL BMI</p>
                    <p class="text-xs text-gray-500 mt-2 uppercase font-bold tracking-widest">Otomatis Terkalkulasi</p>
                </div>

                <!-- Card 3: Rekap Laporan -->
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-8 border-yellow-500">
                    <h3 class="font-black text-gray-700 uppercase tracking-widest text-sm">Laporan</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">REKAPITULASI</p>
                    <p class="text-xs text-gray-500 mt-2 uppercase font-bold tracking-widest">Download PDF</p>
                </div>
            </div>

            <!-- News/Info Section -->
            <div class="mt-10 bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h4 class="font-bold text-blue-900 uppercase tracking-widest text-xs mb-2">Petunjuk Penggunaan:</h4>
                <ul class="text-sm text-blue-800 list-disc list-inside space-y-1">
                    <li>Pastikan Tensi Darah personil dalam keadaan normal sebelum tes fisik.</li>
                    <li>Sistem akan menghitung BMI secara otomatis berdasarkan TB/BB.</li>
                    <li>Personil dengan kategori "Tidak Layak" tidak akan muncul di form nilai SDM.</li>
                </ul>
            </div>
        </div>
    </main>

</body>
</html>