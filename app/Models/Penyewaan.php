<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    public $timestamps = true;
    protected $table = "penyewaan";
    protected $guarded = ['penyewaan_id'];
    protected $primaryKey = 'penyewaan_id';

    protected $fillable = [
        'user_id',
        'penyewa_id',
        'mobil_id',
        'sewa',
        'kembali',
        'harga',
        'lama_sewa',
        'total_denda',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

}
