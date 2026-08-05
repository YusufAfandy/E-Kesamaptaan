<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. MEMBERSIHKAN TABEL (Agar tidak terjadi error Duplicate Entry)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. MEMBUAT AKUN OTORITAS (Admin, SDM, Kapolres)
        // Akun-akun ini diperlukan untuk login sistem
        User::create([
            'nama_lengkap'  => 'Bripka Andi Hermawan',
            'pangkat'       => 'Bripka',
            'nrp'           => 'admin01',
            'jenis_kelamin' => 'L',
            'satker'        => 'Urkes',
            'role'          => 'admin_urkes',
            'password'      => bcrypt('polres123'),
        ]);

        User::create([
            'nama_lengkap'  => 'Aipda Budi Santoso',
            'pangkat'       => 'Aipda',
            'nrp'           => 'sdm01',
            'jenis_kelamin' => 'L',
            'satker'        => 'Bag SDM',
            'role'          => 'tim_sdm',
            'password'      => bcrypt('polres123'),
        ]);

        User::create([
            'nama_lengkap'  => 'AKBP Setiawan Jati',
            'pangkat'       => 'AKBP',
            'nrp'           => 'kapolres',
            'jenis_kelamin' => 'L',
            'satker'        => 'Pimpinan',
            'role'          => 'kapolres',
            'password'      => bcrypt('polres123'),
        ]);

        // 3. DAFTAR ANGGOTA POLISI (Data Uji Coba untuk Grafik)
        $anggota = [
            ['nama' => 'Briptu Aris Permana',   'pangkat' => 'Briptu', 'nrp' => '96010101', 'sk' => 'Sat Reskrim'],
            ['nama' => 'Bripka Deni Setiawan',  'pangkat' => 'Bripka', 'nrp' => '97020202', 'sk' => 'Sat Lantas'],
            ['nama' => 'Aipda Heri Cahyono',    'pangkat' => 'Aipda',  'nrp' => '98030303', 'sk' => 'Sat Sabhara'],
            ['nama' => 'Brigpol Siska Amalia',  'pangkat' => 'Brigpol','nrp' => '99040404', 'sk' => 'Sat Intelkam'],
            ['nama' => 'Iptu Eko Prasetyo',     'pangkat' => 'Iptu',   'nrp' => '95050505', 'sk' => 'Sat Reskrim'],
            ['nama' => 'Bripka Rina Wulandari', 'pangkat' => 'Bripka', 'nrp' => '94060606', 'sk' => 'Sat Lantas'],
            ['nama' => 'Aiptu Agus Santoso',    'pangkat' => 'Aiptu',  'nrp' => '93070707', 'sk' => 'Sat Sabhara'],
            ['nama' => 'Brigpol Dwi Lestari',   'pangkat' => 'Brigpol','nrp' => '92080808', 'sk' => 'Sat Intelkam'],
            ['nama' => 'Iptu Rudi Hartono',     'pangkat' => 'Iptu',   'nrp' => '91090909', 'sk' => 'Sat Reskrim'],
            ['nama' => 'Briptu Siti Nurhaliza', 'pangkat' => 'Briptu', 'nrp' => '90010101', 'sk' => 'Sat Lantas'],
        ];

        // 4. LOOPING UNTUK INSERT DATA ANGGOTA KE DATABASE
        foreach ($anggota as $a) {
            User::create([
                'nama_lengkap'  => $a['nama'],       // 1. Nama
                'pangkat'       => $a['pangkat'],    // 2. Pangkat
                'nrp'           => $a['nrp'],        // 3. NRP
                'jenis_kelamin' => 'L',              // 4. Jenis Kelamin (Default L, sesuaikan jika perlu)
                'satker'        => $a['sk'],         // 5. Kesatuan
                'role'          => 'personil',       // Status sebagai Anggota Biasa
                'password'      => bcrypt('polres123'),
            ]);
        }
    }
}