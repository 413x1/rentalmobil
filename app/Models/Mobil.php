<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    public $timestamps = true; 
    protected $table = "mobil"; 
    protected $guarded = ['mobil_id']; 
    protected $primaryKey = 'mobil_id';

    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk_id', 'merk_id');
    }
    protected $fillable = ['merk_id', 'jenis_mobil', 'nopolisi', 'harga', 'total_denda', 'foto', 'user_id', 'status'];
    
 
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    } 
    public function fotoMobil() 
    { 
        return $this->hasMany(FotoMobil::class); 
    }
}
