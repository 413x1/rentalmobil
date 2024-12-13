<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPenyewa extends Model
{
    public $timestamps = true; 
    protected $table = 'foto_penyewa'; 
    protected $guarded = ['fotopenyewa_id']; 
    protected $primaryKey = 'fotopenyewa_id';
}
