<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    public $timestamps = true;
    protected $table = "merk"; // Nama tabel
    protected $guarded = ['merk_id']; // Lindungi merk_id dari mass assignment

    protected $primaryKey = 'merk_id'; // Tentukan primary key
    public function mobil()
{
    return $this->hasMany(Mobil::class, 'merk_id', 'merk_id');
}

}