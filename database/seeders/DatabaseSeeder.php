<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Merk;
use App\Models\User;
use App\Models\Kategori; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

    #untuk record berikutnya silahkan, beri nilai berbeda pada nilai: nama, email, hp dengan
    #nilai masing-masing anggota kelompok
User::create([ 
    'nama' => 'Muhammad Nauval Firdaus', 
    'email' => 'nauval@gmail.com', 
    'status' => 1, 
    'hp' => '081234567892', 
    'password' => bcrypt('nauval1'), 
]); 
User::create([ 
    'nama' => 'Siti Fatimah', 
    'email' => 'tifa123@gmail.com', 
    'status' => 1, 
    'hp' => '081234567893', 
    'password' => bcrypt('tifa123'), 
]); 
User::create([ 
    'nama' => 'Adinda Putri Pasaribu', 
    'email' => 'adinda123@gmail.com', 
    'status' => 1, 
    'hp' => '081234567894', 
    'password' => bcrypt('dinda123'), 
]); 
User::create([ 
    'nama' => 'Muhammad Bagus Rofiq', 
    'email' => 'bagus123@gmail.com', 
    'status' => 1, 
    'hp' => '081234567895', 
    'password' => bcrypt('bagus123'), 
]); 
User::create([ 
    'nama' => 'Badra Putra', 
    'email' => 'badra123@gmail.com', 
    'status' => 1, 
    'hp' => '081234567896', 
    'password' => bcrypt('badra123'), 
]); 

    #data merk
    Merk::create([
        'merk_mobil' => 'BMW',
    ]);
    Merk::create([
        'merk_mobil' => 'Lamboghini',
    ]);
    Merk::create([
        'merk_mobil' => 'Ferrari',
    ]);
    Merk::create([
        'merk_mobil' => 'Tesla',
    ]);
    }
}
