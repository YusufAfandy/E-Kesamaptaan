<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('pengajuans', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('tipe'); // 'TAMBAH' atau 'HAPUS'
        $table->string('nrp');
        $table->string('nama_lengkap');
        $table->string('pangkat');
        $table->string('satker');
        $table->enum('status', ['PENDING', 'DISETUJUI', 'DITOLAK'])->default('PENDING');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
}
