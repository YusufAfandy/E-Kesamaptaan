<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk membersihkan tabel

class UserSeeder extends Seeder
{
    public function run()
    {
        // 0. MEMBERSIHKAN TABEL (Mencegah error Duplicate Entry)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Akun Admin Urkes
        User::create([
            'nrp'           => 'admin01',
            'nama_lengkap'  => 'Bripka Andi Hermawan',
            'pangkat'       => 'Bripka',
            'satker'        => 'Urkes',
            'jenis_kelamin' => 'L',
            'role'          => 'admin_urkes',
            'password'      => bcrypt('polres123'),
        ]);

        // 2. Akun Tim SDM
        User::create([
            'nrp'           => 'sdm01',
            'nama_lengkap'  => 'Aipda Budi Santoso',
            'pangkat'       => 'Aipda',
            'satker'        => 'SDM',
            'jenis_kelamin' => 'L',
            'role'          => 'tim_sdm',
            'password'      => bcrypt('polres123'),
        ]);

        // 3. Akun Kapolres
        User::create([
            'nrp'           => 'kapolres',
            'nama_lengkap'  => 'AKBP Setiawan Jati',
            'pangkat'       => 'AKBP',
            'satker'        => 'Pimpinan',
            'jenis_kelamin' => 'L',
            'role'          => 'kapolres',
            'password'      => bcrypt('polres123'),
        ]);

        // 4. Daftar Anggota dengan Satker berbeda-beda (Untuk Grafik)
        $anggota = [
            ['nrp' => '96010101', 'nama' => 'Briptu Aris Permana', 'pangkat' => 'Briptu', 'sk' => 'Sat Reskrim'],
            ['nrp' => '97020202', 'nama' => 'Bripka Deni Setiawan', 'pangkat' => 'Bripka', 'sk' => 'Sat Lantas'],
            ['nrp' => '98030303', 'nama' => 'Aipda Heri Cahyono', 'pangkat' => 'Aipda', 'sk' => 'Sat Sabhara'],
            ['nrp' => '99040404', 'nama' => 'Brigpol Siska Amalia', 'pangkat' => 'Brigpol', 'sk' => 'Sat Intelkam'],
            ['nrp' => '95050505', 'nama' => 'Iptu Eko Prasetyo', 'pangkat' => 'Iptu', 'sk' => 'Sat Reskrim'],
            ['nrp' => '94060606', 'nama' => 'Bripka Rina Wulandari', 'pangkat' => 'Bripka', 'sk' => 'Sat Lantas'],
            ['nrp' => '93070707', 'nama' => 'Aiptu Agus Santoso', 'pangkat' => 'Aiptu', 'sk' => 'Sat Sabhara'],
            ['nrp' => '92080808', 'nama' => 'Brigpol Dwi Lestari', 'pangkat' => 'Brigpol', 'sk' => 'Sat Intelkam'],
            ['nrp' => '91090909', 'nama' => 'Iptu Rudi Hartono', 'pangkat' => 'Iptu', 'sk' => 'Sat Reskrim'],
            ['nrp' => '90010101', 'nama' => 'Briptu Siti Nurhaliza', 'pangkat' => 'Briptu', 'sk' => 'Sat Lantas'],
        ];

        foreach ($anggota as $a) {
            User::create([
                'nrp' => $a['nrp'],
                'nama_lengkap' => $a['nama'],
                'pangkat' => $a['pangkat'],
                'satker' => $a['sk'], // Sekarang Satker akan tersimpan
                'jenis_kelamin' => 'L',
                'role' => 'personil',
                'password' => bcrypt('polres123'),
            ]);
        }
    }
}