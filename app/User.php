<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nrp', 'nama_lengkap', 'pangkat', 'satker', 'jenis_kelamin', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    // Relasi: Satu personil memiliki banyak riwayat medis
    public function medis() {
        return $this->hasMany('App\Medis', 'user_id');
    }

    // Relasi: Satu personil memiliki banyak riwayat nilai fisik
    public function samaptas() {
        return $this->hasMany('App\Samapta', 'user_id');
    }
}