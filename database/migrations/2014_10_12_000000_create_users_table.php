<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id'); // Ini menghasilkan BIGINT UNSIGNED
        $table->string('nrp')->unique();
        $table->string('nama_lengkap');
        $table->string('pangkat');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('password');
        $table->enum('role', ['admin_urkes', 'tim_sdm', 'personil', 'kapolres']);
        $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
