<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoMobil extends Model
{
    public $timestamps = true; 
    protected $table = 'foto_mobil'; 
    protected $guarded = ['fotomobil_id']; 
    protected $primaryKey = 'fotomobil_id';
}
