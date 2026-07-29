<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamaptasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('samaptas', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id')->unsigned(); // ID Anggota yang tes
        $table->string('periode'); // Contoh: 2024-Semester 1
        
        // Samapta A
        $table->integer('lari_meter'); // Jarak tempuh lari 12 menit
        
        // Samapta B
        $table->integer('pull_up');
        $table->integer('sit_up');
        $table->integer('push_up');
        $table->decimal('shuttle_run', 5, 2); // Waktu detik
        
        // Hasil Nilai Akhir
        $table->decimal('nilai_akhir', 5, 2);
        $table->timestamps();

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
        Schema::dropIfExists('samaptas');
    }
}
