<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Samapta extends Model
{
    protected $table = 'samaptas';
    protected $fillable = [
        'user_id', 'periode', 'lari_meter', 'pull_up', 'sit_up', 'push_up', 'shuttle_run', 'nilai_akhir'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}