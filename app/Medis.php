<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Medis extends Model
{
    protected $table = 'medis';
    protected $fillable = [
        'user_id', 'tanggal_periksa', 'tensi_sistolik', 'tensi_diastolik', 
        'tinggi_badan', 'berat_badan', 'bmi', 'status_kelayakan', 'catatan'
    ];

    // Relasi ke User
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}