<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Mobil;
use App\Helpers\ImageHelper;
use App\Models\FotoMobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobil = Mobil::orderBy('updated_at', 'desc')->get(); 
        return view('backend.v_mobil.index', [ 
            'judul' => 'Data Jenis Mobil', 
            'index' => $mobil 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merk = Merk::orderBy('merk_mobil', 'asc')->get(); 
        return view('backend.v_mobil.create', [ 
            'judul' => 'Tambah Jenis Mobil', 
            'merk' => $merk 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([ 
            'merk_id' => 'required|exists:merk,merk_id',  
            'jenis_mobil' => 'required|max:255|unique:mobil', 
            'total_denda' => 'required', 
            'harga' => 'required', 
            'nopolisi' => 'required', 
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024', 
        ], $messages = [ 
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.' 
        ]); 
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 0; 
 
        if ($request->file('foto')) { 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-mobil/'; 
 
            // Simpan gambar asli 
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName); 
            $validatedData['foto'] = $fileName; 
 
            // create thumbnail 1 (lg) 
            $thumbnailLg = 'thumb_lg_' . $originalFileName; 
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null); 
 
            // create thumbnail 2 (md) 
            $thumbnailMd = 'thumb_md_' . $originalFileName; 
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519); 
 
            // create thumbnail 3 (sm) 
            $thumbnailSm = 'thumb_sm_' . $originalFileName; 
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110); 

            //debug
            // dd('File yang akan diupload:', $file->getClientOriginalName(), $originalFileName, $directory);

            // Simpan nama file asli di database 
            $validatedData['foto'] = $originalFileName; 
            } 
            Mobil::create($validatedData); 
            return redirect()->route('backend.mobil.index')->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mobil = Mobil::with('fotoMobil')->findOrFail($id); 
        $merk = Merk::orderBy('merk_mobil', 'asc')->get(); 
        return view('backend.v_mobil.show', [ 
            'judul' => 'Detail Mobil', 
            'show' => $mobil, 
            'merk' => $merk 
        ]);
    }

    // method untuk menyimpan foto tambahan
    public function storeFoto(Request $request)
    {
        //valiadasi input 
        $request->validate([
            'mobil_id' => 'required|exists:mobil,id', #dibagian exits titik dua hanya sekali tidak doubel
            'foto_mobil.*' => 'image|mimes:jpeg,png,jpg,gif|file|max:1024',
        ]);
        if ($request->hasFile('foto_mobil')) { 
            foreach ($request->file('foto_mobil') as $file) { 
                // Buat nama file yang unik 
                $extension = $file->getClientOriginalExtension(); 
                $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
                $directory = 'storage/img-mobil/'; 
 
                // Simpan dan resize gambar menggunakan ImageHelper 
                ImageHelper::uploadAndResize($file, $directory, $filename, 800, null); 
                // Simpan data ke database 
                FotoMobil::create([ 
                    'mobil_id' => $request->produk_id, 
                    'foto' => $filename, 
                ]); 
            } 
        } 
        return redirect()->route('backend.produk.show', $request->produk_id) 
        ->with('success', 'Foto berhasil ditambahkan.'); 
    }

    // Method untuk menghapus foto 
    public function destroyFoto($id) 
    { 
        $foto = FotoMobil::findOrFail($id); 
        $produkId = $foto->mobil_id; 
 
        // Hapus file gambar dari storage 
        $imagePath = public_path('storage/img-mobil/') . $foto->foto; 
        if (file_exists($imagePath)) { 
            unlink($imagePath); 
        } 
        // Hapus record dari database 
        $foto->delete(); 
 
        return redirect()->route('backend.mobil.show', $produkId) 
            ->with('success', 'Foto berhasil dihapus.'); 
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mobil = Mobil::findOrFail($id);
        $merk = Merk::orderBy('merk_mobil', 'asc')->get();
        return view('backend.v_mobil.edit', [
        'judul' => 'Ubah Jenis Mobil',
        'edit' => $mobil, // Kirim data produk ke view
        'merk' => $merk, // Kirim data kategori ke view
       ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Temukan data mobil berdasarkan mobil_id
        $mobil = Mobil::findOrFail($id);
    
        $rules = [
            'jenis_mobil' => 'required|max:255|unique:mobil,jenis_mobil,' . $id. ',mobil_id', 
            'merk_id' => 'required',
            'status' => 'required',
            'total_denda' => 'required',
            'harga' => 'required',
            'nopolisi' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
    
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];
    
        // Validasi data yang diterima dari request
        $validatedData = $request->validate($rules, $messages);
    
        // Menambahkan user_id yang sedang login
        $validatedData['user_id'] = auth()->id();
    
        // Menghapus gambar lama jika ada dan mengganti dengan gambar baru
        if ($request->file('foto')) {
            // Hapus gambar lama jika ada
            if ($mobil->foto) {
                $oldImagePath = public_path('storage/img-mobil/') . $mobil->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
    
                // Hapus thumbnail jika ada
                $oldThumbnailLg = public_path('storage/img-mobil/') . 'thumb_lg_' . $mobil->foto;
                if (file_exists($oldThumbnailLg)) {
                    unlink($oldThumbnailLg);
                }
                $oldThumbnailMd = public_path('storage/img-mobil/') . 'thumb_md_' . $mobil->foto;
                if (file_exists($oldThumbnailMd)) {
                    unlink($oldThumbnailMd);
                }
                $oldThumbnailSm = public_path('storage/img-mobil/') . 'thumb_sm_' . $mobil->foto;
                if (file_exists($oldThumbnailSm)) {
                    unlink($oldThumbnailSm);
                }
            }
    
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-mobil/';
    
            // Simpan gambar asli
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            $validatedData['foto'] = $fileName;
    
            // Buat thumbnail 1 (lg)
            $thumbnailLg = 'thumb_lg_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailLg, 800, null);
    
            // Buat thumbnail 2 (md)
            $thumbnailMd = 'thumb_md_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailMd, 500, 519);
    
            // Buat thumbnail 3 (sm)
            $thumbnailSm = 'thumb_sm_' . $originalFileName;
            ImageHelper::uploadAndResize($file, $directory, $thumbnailSm, 100, 110);
        }
    
        // Lakukan update berdasarkan merk_id
        Mobil::where('mobil_id', $id)->update($validatedData); 
    
        return redirect()->route('backend.mobil.index')->with('success', 'Data berhasil diperbaharui');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mobil = Mobil::findOrFail($id); 
        $directory = public_path('storage/img-mobil/'); 
 
        if ($mobil->foto) { 
            // Hapus gambar asli 
            $oldImagePath = $directory . $mobil->foto; 
            if (file_exists($oldImagePath)) { 
                unlink($oldImagePath); 
            } 
 
            // Hapus thumbnail lg 
            $thumbnailLg = $directory . 'thumb_lg_' . $mobil->foto; 
            if (file_exists($thumbnailLg)) { 
                unlink($thumbnailLg); 
            } 
 
            // Hapus thumbnail md 
            $thumbnailMd = $directory . 'thumb_md_' . $mobil->foto; 
            if (file_exists($thumbnailMd)) { 
                unlink($thumbnailMd); 
            } 
 
            // Hapus thumbnail sm 
            $thumbnailSm = $directory . 'thumb_sm_' . $mobil->foto; 
            if (file_exists($thumbnailSm)) { 
                unlink($thumbnailSm); 
            } 
        } 
 
        // Hapus foto produk lainnya di tabel foto_produk 
        $fotoMobils = FotoMobil::where('mobil_id', $id)->get(); 
        foreach ($fotoMobils as $fotoMobil) { 
            $fotoPath = $directory . $fotoMobil->foto; 
            if (file_exists($fotoPath)) { 
                unlink($fotoPath); 
            } 
            $fotoMobil->delete(); 
        } 
 
        $mobil->delete(); 
 
        return redirect()->route('backend.mobil.index')->with('success', 'Data berhasil dihapus');
    
    }

     // Method untuk Form Laporan Produk 
     public function formMobil() 
     { 
         return view('backend.v_mobil.form', [ 
             'judul' => 'Laporan Data Mobil', 
         ]); 
     } 
  
     // Method untuk Cetak Laporan Produk 
     public function cetakMobil(Request $request) 
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
         $query =  Mobil::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('mobil_id', 'desc'); 

     $mobil = $query->get(); 
     return view('backend.v_mobil.cetak', [ 
         'judul' => 'Laporan Mobil', 
         'tanggalAwal' => $tanggalAwal, 
         'tanggalAkhir' => $tanggalAkhir, 
         'cetak' => $mobil 
     ]); 
    }  
}
