<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyewa extends Model
{
    public $timestamps = true; 
    protected $table = "penyewa"; 
    protected $guarded = ['penyewa_id']; 
    protected $primaryKey = 'penyewa_id';
    public function fotoPenyewa() 
    { 
        return $this->hasMany(FotoPenyewa::class); 
    }
    // use HasFactory;
     // Nama tabel yang digunakan
    //  protected $table = 'penyewa';
     // Kolom yang bisa diisi (mass assignment)
     protected $fillable = [
         'nama',
         'email',
         'telepon',
         'alamat',
         'tanggal_lahir',
         'nomor_identitas',
         'foto',
         'status',
     ];
 
     // Kolom yang harus di-cast
     // Mengatur tanggal lahir sebagai tipe data date
     // Mengatur status sebagai tipe data boolean
     // Menandakan apakah penyewa membutuhkan sopir
     protected $casts = [
         'tanggal_lahir' => 'date', 
    //      'status' => 'boolean',     
    //      'driver' => 'boolean',     
     ];
 
     // Menentukan nilai default untuk kolom status
     // Status default aktif (1)
     // Default tidak membutuhkan sopir
    //  protected $attributes = [
    //      'status' => 1, 
    //      'driver' => false, 
    //  ];
 
     // Relasi dengan model Penyewaan (jika ada)
     // Jika Penyewa menyewa Mobil, misalnya
    //  public function penyewaan()
    //  {
    //      return $this->hasMany(Penyewaan::class); // Relasi satu ke banyak dengan model Penyewaan
    //  }
}
