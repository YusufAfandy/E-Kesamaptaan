<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('medis', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unsigned(); // Relasi ke personil
        $table->date('tanggal_periksa');
        $table->integer('tensi_sistolik');
        $table->integer('tensi_diastolik');
        $table->decimal('tinggi_badan', 5, 2); // Contoh: 170.50
        $table->decimal('berat_badan', 5, 2);  // Contoh: 65.20
        $table->decimal('bmi', 5, 2);
        $table->enum('status_kelayakan', ['Memenuhi Syarat', 'Tidak Memenuhi Syarat']);
        $table->text('catatan')->nullable();
        $table->timestamps();

        // Foreign Key
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    // Pastikan baris ini ada untuk menghapus tabel saat rollback
    Schema::dropIfExists('medis');
    }
}
