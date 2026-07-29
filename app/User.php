<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Kolom yang BOLEH diisi secara massal.
     * Pastikan semua kolom baru (nrp, pangkat, satker, dll) ada di sini.
     */
    protected $fillable = [
        'nrp', 
        'nama_lengkap', 
        'pangkat', 
        'satker', 
        'jenis_kelamin', 
        'password', 
        'role',
    ];

    /**
     * Kolom yang harus disembunyikan saat data diubah jadi array/json.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * RELASI: Satu User (Personil) bisa memiliki banyak riwayat pemeriksaan medis.
     */
    public function medis() {
        return $this->hasMany('App\Medis', 'user_id');
    }

    /**
     * RELASI: Satu User (Personil) bisa memiliki banyak riwayat nilai kesamaptaan.
     */
    public function samaptas() {
        return $this->hasMany('App\Samapta', 'user_id');
    }
}