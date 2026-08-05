<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuans';
    protected $fillable = ['tipe', 'nrp', 'nama_lengkap', 'pangkat', 'satker', 'status'];
}