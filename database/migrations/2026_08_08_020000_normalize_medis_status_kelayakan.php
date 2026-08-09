<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class NormalizeMedisStatusKelayakan extends Migration
{
    /**
     * Menyamakan enum status dengan nilai yang digunakan aplikasi.
     *
     * Migration ini aman untuk database lama yang masih menggunakan:
     * Layak / Tidak Layak.
     */
    public function up()
    {
        // Tahap 1: izinkan nilai lama dan baru.
        DB::statement("ALTER TABLE `medis` MODIFY `status_kelayakan` ENUM('Layak','Tidak Layak','Memenuhi Syarat','Tidak Memenuhi Syarat') NOT NULL");

        // Tahap 2: migrasikan data lama tanpa menghapus record apa pun.
        DB::statement("UPDATE `medis` SET `status_kelayakan` = 'Memenuhi Syarat' WHERE `status_kelayakan` = 'Layak'");
        DB::statement("UPDATE `medis` SET `status_kelayakan` = 'Tidak Memenuhi Syarat' WHERE `status_kelayakan` = 'Tidak Layak'");

        // Tahap 3: kunci enum ke nilai yang benar-benar dipakai aplikasi.
        DB::statement("ALTER TABLE `medis` MODIFY `status_kelayakan` ENUM('Memenuhi Syarat','Tidak Memenuhi Syarat') NOT NULL");
    }

    public function down()
    {
        // Kembalikan format lama tanpa menghapus baris.
        DB::statement("ALTER TABLE `medis` MODIFY `status_kelayakan` ENUM('Memenuhi Syarat','Tidak Memenuhi Syarat','Layak','Tidak Layak') NOT NULL");

        DB::statement("UPDATE `medis` SET `status_kelayakan` = 'Layak' WHERE `status_kelayakan` = 'Memenuhi Syarat'");
        DB::statement("UPDATE `medis` SET `status_kelayakan` = 'Tidak Layak' WHERE `status_kelayakan` = 'Tidak Memenuhi Syarat'");

        DB::statement("ALTER TABLE `medis` MODIFY `status_kelayakan` ENUM('Layak','Tidak Layak') NOT NULL");
    }
}
