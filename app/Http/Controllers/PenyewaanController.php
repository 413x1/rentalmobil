<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Merk;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Penyewa;
use App\Models\Penyewaan;
use Illuminate\Http\Request;

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewaan = Penyewaan::orderBy('updated_at', 'desc')->get(); 
        return view('backend.v_penyewaan.index', [ 
            'judul' => 'Data Penyewaan', 
            'index' => $penyewaan 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::orderBy('nama', 'asc')->get(); 
        $penyewa = Penyewa::orderBy('nama', 'asc')->get(); 
        $merk = Merk::orderBy('merk_mobil', 'asc')->get(); 
        $mobil = Mobil::orderBy('jenis_mobil', 'asc')->get(); 
        return view('backend.v_penyewaan.create', [ 
            'judul' => 'Tambah Penyewaan', 
            'user' => $user,
            'penyewa' => $penyewa,
            'merk' => $merk,
            'mobil' => $mobil
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'user_id' => 'required',
            'penyewa_id' => 'required',
            'mobil_id' => 'required',
            'sewa' => 'required|date',
            'kembali' => 'required|date',
            'hari_terlambat' => 'required|numeric'
        ]);

        // Ambil data mobil untuk harga
        $mobil = Mobil::findOrFail($request->mobil_id);
        $harga_per_hari = $mobil->harga;

        // Menghitung lama sewa
        $sewa_date = Carbon::parse($request->sewa);
        $kembali_date = Carbon::parse($request->kembali);
        $lama_sewa = $sewa_date->diffInDays($kembali_date);
        
        // Menghitung total harga sewa
        $total_harga = $lama_sewa * $harga_per_hari;

        // Hitung total denda jika ada
        $total_denda = 0;
        if ($request->hari_terlambat > 0) {
            // Jika terlambat, misalnya denda 1000 per hari keterlambatan
            $total_denda = $request->hari_terlambat * $mobil->total_denda;
        }

        // Total harga sewa + denda
        $total_harga_denda = $total_harga + $total_denda;

        // Menyimpan data penyewaan ke database
        Penyewaan::create([
            'user_id' => $request->user_id,
            'penyewa_id' => $request->penyewa_id,
            'mobil_id' => $request->mobil_id,
            'sewa' => $request->sewa,
            'kembali' => $request->kembali,
            'harga' => $harga_per_hari,
            'lama_sewa' => $lama_sewa,
            'total_denda' => $total_denda,
            'total_harga' => $total_harga_denda,
        ]);

        return redirect()->route('backend.penyewaan.index')->with('success', 'Penyewaan berhasil ditambahkan!');
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $penyewaan = Penyewaan::findOrFail($id);
    $user = User::orderBy('nama', 'asc')->get();
    $penyewa = Penyewa::orderBy('nama', 'asc')->get();
    $merk = Merk::orderBy('merk_mobil', 'asc')->get();
    $mobil = Mobil::orderBy('jenis_mobil', 'asc')->get();

    // Menghitung total harga berdasarkan durasi sewa
    $sewaDate = \Carbon\Carbon::parse($penyewaan->sewa);
    $kembaliDate = \Carbon\Carbon::parse($penyewaan->kembali);
    $diffInDays = $sewaDate->diffInDays($kembaliDate);
    $totalHarga = $penyewaan->harga * $diffInDays;

    // Menghitung denda jika ada keterlambatan
    $today = \Carbon\Carbon::now();
    $lateDays = $kembaliDate->diffInDays($today, false); // false untuk menghitung hari terlambat
    $dendaPerHari = 50000; // Denda per hari, misalnya Rp 50.000
    $totalDenda = 0;

    if ($lateDays > 0) {
        $totalDenda = $lateDays * $dendaPerHari;
    }

    return view('backend.v_penyewaan.edit', [ 
        'judul' => 'Ubah Penyewaan',
        'edit' => $penyewaan, 
        'user' => $user,
        'penyewa' => $penyewa,
        'merk' => $merk,
        'mobil' => $mobil,
        'totalHarga' => $totalHarga, // Pass total harga ke view
        'totalDenda' => $totalDenda, // Pass total denda ke view
    ]); 
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $penyewaan = Penyewaan::findOrFail($id);

    // Validasi input form
    $rules = [
        'user_id' => 'required', 
        'penyewa_id' => 'required', 
        'merk_id' => 'required', 
        'mobil_id' => 'required', 
        'sewa' => 'required|date', 
        'kembali' => 'required|date|after_or_equal:sewa',  
        'harga' => 'required|numeric',  // Pastikan harga adalah angka
        'nopolisi' => 'required|string', // Nopolisi
    ];

    $messages = [ 
        'sewa.required' => 'Tanggal sewa harus diisi.', 
        'kembali.required' => 'Tanggal kembali harus diisi.', 
        'kembali.after_or_equal' => 'Tanggal kembali harus lebih besar atau sama dengan Tanggal sewa.', 
    ];

    // Validasi data
    $validatedData = $request->validate($rules, $messages);

    // Perhitungan Total Harga dan Denda
    $sewaDate = \Carbon\Carbon::parse($request->sewa);
    $kembaliDate = \Carbon\Carbon::parse($request->kembali);
    $diffInDays = $sewaDate->diffInDays($kembaliDate);
    $totalHarga = $request->harga * $diffInDays;

    $today = \Carbon\Carbon::now();
    $lateDays = $kembaliDate->diffInDays($today, false); // false untuk menghitung hari terlambat
    $dendaPerHari = 50000; // Denda per hari, misalnya Rp 50.000
    $totalDenda = 0;

    if ($lateDays > 0) {
        $totalDenda = $lateDays * $dendaPerHari;
    }

    // Update data penyewaan
    $penyewaan->update(array_merge($validatedData, [
        'total_harga' => $totalHarga, // Simpan total harga
        'total_denda' => $totalDenda, // Simpan total denda
    ]));

    return redirect()->route('backend.penyewaan.index')->with('success', 'Data berhasil diperbaharui'); 
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penyewaan = Penyewaan::findOrFail($id);
        
        $penyewaan->delete(); 
        return redirect()->route('backend.penyewaan.index')->with('success', 'Data berhasil dihapus'); 
    }

    // Method untuk Form Laporan Produk 
    public function formPenyewaan() 
    { 
        return view('backend.v_penyewaan.form', [ 
            'judul' => 'Laporan Data Penyewaan', 
        ]); 
    } 
 
    // Method untuk Cetak Laporan Produk 
    public function cetakPenyewaan(Request $request) 
    { 
        // Menambahkan aturan validasi 
        $request->validate([ 
            'tanggal_awal' => 'required|date', 
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal', 
        ], [ 
            'tanggal_awal.required' => 'Tanggal Awal harus diisi.', 
            'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.', 
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.', 
        ]); 
 
        $tanggalAwal = $request->input('tanggal_awal'); 
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query =  Penyewaan::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('penyewaan_id', 'desc'); 

    $penyewaan = $query->get(); 
    return view('backend.v_penyewaan.cetak', [ 
        'judul' => 'Laporan Penyewaan', 
        'tanggalAwal' => $tanggalAwal, 
        'tanggalAkhir' => $tanggalAkhir, 
        'cetak' => $penyewaan 
    ]); 
   } 
}
