@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-8 border-yellow-500">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 uppercase">Edit Pemeriksaan Medis</h2>

    <form action="{{ url('/medis/'.$medis->id.'/update') }}" method="POST">
        {{ csrf_field() }}

        <div class="mb-4">
            <label class="block font-bold text-sm mb-1">PERSONIL</label>
            <select name="user_id" class="w-full p-2 border rounded">
                @foreach($personil as $p)
                    <option value="{{ $p->id }}" {{ $medis->user_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nrp }} - {{ $p->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Contoh Input Tensi dengan Value Lama -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold text-sm mb-1">TENSI SISTOLIK</label>
                <input type="number" name="tensi_sistolik" value="{{ $medis->tensi_sistolik }}" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block font-bold text-sm mb-1">TENSI DIASTOLIK</label>
                <input type="number" name="tensi_diastolik" value="{{ $medis->tensi_diastolik }}" class="w-full p-2 border rounded" required>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-bold text-sm mb-1">TINGGI BADAN (cm)</label>
                <input type="number" id="tb" name="tinggi_badan" value="{{ $medis->tinggi_badan }}" step="0.1" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="block font-bold text-sm mb-1">BERAT BADAN (kg)</label>
                <input type="number" id="bb" name="berat_badan" value="{{ $medis->berat_badan }}" step="0.1" class="w-full p-2 border rounded" required>
            </div>
        </div>

        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
            <label class="block font-bold text-blue-900 text-sm mb-1">HASIL BMI</label>
            <input type="text" id="bmi" name="bmi" value="{{ $medis->bmi }}" readonly class="text-2xl font-black bg-transparent outline-none text-blue-900">
        </div>

        <div class="mb-6">
            <label class="block font-bold text-sm mb-1">STATUS KELAYAKAN</label>
            <select name="status_kelayakan" class="w-full p-2 border rounded font-bold">
                <option value="Memenuhi Syarat" {{ $medis->status_kelayakan == 'Memenuhi Syarat' ? 'selected' : '' }}>Memenuhi Syarat (MS)</option>
                <option value="Tidak Memenuhi Syarat" {{ $medis->status_kelayakan == 'Tidak Memenuhi Syarat' ? 'selected' : '' }}>Tidak Memenuhi Syarat (TMS)</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="w-full bg-yellow-500 text-white font-bold py-3 rounded hover:bg-black transition">UPDATE DATA</button>
            <a href="{{ url('/medis') }}" class="w-full bg-gray-200 text-center py-3 rounded font-bold">BATAL</a>
        </div>
    </form>
</div>

<!-- Sertakan JavaScript BMI yang sama dengan create.blade.php di sini -->
<script>
    const tbInput = document.getElementById('tb');
    const bbInput = document.getElementById('bb');
    const bmiInput = document.getElementById('bmi');
    const ketBmi = document.getElementById('keterangan_bmi');

    function hitungBMI() {
        let tb = tbInput.value / 100; // Ubah cm ke meter
        let bb = bbInput.value;

        if(tb > 0 && bb > 0) {
            let bmi = (bb / (tb * tb)).toFixed(2);
            bmiInput.value = bmi;

            // Logika Penentuan Status BMI
            if(bmi < 18.5) { 
                ketBmi.innerText = "STATUS: KURUS"; 
                ketBmi.style.color = "orange"; 
            }
            else if(bmi >= 18.5 && bmi <= 25) { 
                ketBmi.innerText = "STATUS: IDEAL / NORMAL"; 
                ketBmi.style.color = "green"; 
            }
            else if(bmi > 25 && bmi <= 30) { 
                ketBmi.innerText = "STATUS: GEMUK (OVERWEIGHT)"; 
                ketBmi.style.color = "orange"; 
            }
            else { 
                ketBmi.innerText = "STATUS: OBESITAS (PERLU ATENSI)"; 
                ketBmi.style.color = "red"; 
            }
        }
    }

    // Jalankan fungsi saat user mengetik
    tbInput.addEventListener('input', hitungBMI);
    bbInput.addEventListener('input', hitungBMI);

    // PENTING: Jalankan fungsi saat halaman selesai dimuat 
    // Agar data lama langsung terhitung statusnya
    window.onload = hitungBMI;
</script>
@endsection