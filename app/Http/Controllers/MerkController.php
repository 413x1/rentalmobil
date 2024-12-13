<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merk = Merk::orderBy('merk_mobil', 'asc')->get(); 
        return view('backend.v_merk.index', [ 
            'judul' => 'Data Merk Mobil', 
            'index' => $merk 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_merk.create', [ 
            'judul' => 'Tambah Merk Mobil', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request); 
        $validatedData = $request->validate([ 
            'merk_mobil' => 'required|max:255|unique:merk', 
        ]); 
        Merk::create($validatedData); 
        return redirect()->route('backend.merk.index')->with('success', 'Data berhasil tersimpan'); 
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
        $merk = Merk::find($id); 
        return view('backend.v_merk.edit', [ 
        'judul' => 'Ubah Merk Mobil', 
        'edit' => $merk 
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Pastikan menggunakan 'merk_id' sebagai kunci utama
    $rules = [ 
        'merk_mobil' => 'required|max:255|unique:merk,merk_mobil,' . $id . ',merk_id', 
    ]; 
    // Melakukan validasi data
    $validatedData = $request->validate($rules); 

    // Lakukan update berdasarkan merk_id
    Merk::where('merk_id', $id)->update($validatedData); 

    return redirect()->route('backend.merk.index')->with('success', 'Data berhasil diperbaharui');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $merk = Merk::findOrFail($id);
        $merk->delete(); 
        return redirect()->route('backend.merk.index')->with('success', 'Data berhasil dihapus');
    }

      // Method untuk Form Laporan Produk 
     public function formMerk() 
     { 
         return view('backend.v_merk.form', [ 
             'judul' => 'Laporan Data Merk Mobil', 
         ]); 
     } 
  
     // Method untuk Cetak Laporan Produk 
     public function cetakMerk(Request $request) 
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
         $query =  Merk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('merk_id', 'desc'); 

     $merk = $query->get(); 
     return view('backend.v_merk.cetak', [ 
         'judul' => 'Laporan Merk Mobil', 
         'tanggalAwal' => $tanggalAwal, 
         'tanggalAkhir' => $tanggalAkhir, 
         'cetak' => $merk 
     ]); 
    } 
}
