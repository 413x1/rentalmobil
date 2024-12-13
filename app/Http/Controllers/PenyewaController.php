<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Helpers\ImageHelper;
use App\Models\FotoPenyewa;
use Illuminate\Http\Request;



class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::orderBy('updated_at', 'asc')->get(); 
        return view('backend.v_penyewa.index', [ 
            'judul' => 'Data Penyewa', 
            'index' => $penyewa 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_penyewa.create', [ 
            'judul' => 'Tambah Penyewa', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewa,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nomor_identitas' => 'required|string|max:50|unique:penyewa,nomor_identitas',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024', 
        ], $messages = [ 
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.' 
        ]); 
        // dd('Data berhasil divalidasi:', $validatedData);
        // $validatedData['user_id'] = auth()->id();

        if ($request->file('foto')) { 
            // dd('File foto ditemukan', $request->file('foto')->getClientOriginalName());
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-foto/'; 
 
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

        // Menyimpan data penyewa
        // dd('Data berhasil disimpan', $validatedData);
         // Tentukan nilai default untuk status
        $validatedData['status'] = $validatedData['status'] ?? 1; 
        Penyewa::create($validatedData);
        return redirect()->route('backend.penyewa.index')->with('success', 'Penyewa berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penyewa = Penyewa::with('fotoPenyewa')->findOrFail($id);
        return view('backend.v_penyewa.show', [ 
            'judul' => 'Detail Penyewa', 
            'show' => $penyewa
        ]);
    }

    public function storeFoto(Request $request)
    {
        //valiadasi input 
        $request->validate([
            'penyewa_id' => 'required|exists:penyewa,id', #dibagian exits titik dua hanya sekali tidak doubel
            'foto_penyewa.*' => 'image|mimes:jpeg,png,jpg,gif|file|max:1024',
        ]);
        if ($request->hasFile('foto_penyewa')) { 
            foreach ($request->file('foto_penyewa') as $file) { 
                // Buat nama file yang unik 
                $extension = $file->getClientOriginalExtension(); 
                $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
                $directory = 'storage/img-foto/'; 
 
                // Simpan dan resize gambar menggunakan ImageHelper 
                ImageHelper::uploadAndResize($file, $directory, $filename, 800, null); 
                // Simpan data ke database 
                FotoPenyewa::create([ 
                    'penyewa_id' => $request->penyewa_id, 
                    'foto' => $filename, 
                ]); 
            } 
        } 
        return redirect()->route('backend.penyewa.show', $request->penyewa_id) 
        ->with('success', 'Foto berhasil ditambahkan.'); 
    }

     // Method untuk menghapus foto 
     public function destroyFoto($id) 
     { 
         $foto = FotoPenyewa::findOrFail($id); 
         $penyewaId = $foto->penyewa_id; 
  
         // Hapus file gambar dari storage 
         $imagePath = public_path('storage/img-foto/') . $foto->foto; 
         if (file_exists($imagePath)) { 
             unlink($imagePath); 
         } 
         // Hapus record dari database 
         $foto->delete(); 
  
         return redirect()->route('backend.penyewa.show', $penyewaId) 
             ->with('success', 'Foto berhasil dihapus.'); 
     } 
 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        return view('backend.v_penyewa.edit', [
        'judul' => 'Ubah Penyewa',
        'edit' => $penyewa, // Kirim data produk ke view
       ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $penyewa = Penyewa::findOrFail($id); 
        $rules = [ 
           'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penyewa,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nomor_identitas' => 'required|string|max:50|unique:penyewa,nomor_identitas',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024', 
        ]; $messages = [ 
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.' 
        ]; 
        $validatedData = $request->all(); 
        // $validatedData['user_id'] = auth()->id(); 
        $validatedData = $request->validate($rules, $messages); 
 
        if ($request->file('foto')) { 
            //hapus gambar lama 
            if ($penyewa->foto) { 
                $oldImagePath = public_path('storage/img-foto/') . $penyewa->foto; 
                if (file_exists($oldImagePath)) { 
                    unlink($oldImagePath); 
                } 
                $oldThumbnailLg = public_path('storage/img-foto/') . 'thumb_lg_' . $penyewa->foto; 
                if (file_exists($oldThumbnailLg)) { 
                    unlink($oldThumbnailLg); 
                } 
                $oldThumbnailMd = public_path('storage/img-foto/') . 'thumb_md_' . $penyewa->foto; 
                if (file_exists($oldThumbnailMd)) { 
                    unlink($oldThumbnailMd); 
                } 
                $oldThumbnailSm = public_path('storage/img-foto/') . 'thumb_sm_' . $penyewa->foto; 
                if (file_exists($oldThumbnailSm)) { 
                    unlink($oldThumbnailSm); 
                } 
            } 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-foto/'; 
 
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

           // Simpan nama file asli di database 
           $validatedData['foto'] = $originalFileName; 
       } 

       $penyewa->update($validatedData); 
       return redirect()->route('backend.penyewa.index')->with('success', 'Data berhasil diperbaharui'); 
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penyewa = Penyewa::findOrFail($id); 
        $directory = public_path('storage/img-foto/'); 
 
        if ($penyewa->foto) { 
            // Hapus gambar asli 
            $oldImagePath = $directory . $penyewa->foto; 
            if (file_exists($oldImagePath)) { 
                unlink($oldImagePath); 
            } 
 
            // Hapus thumbnail lg 
            $thumbnailLg = $directory . 'thumb_lg_' . $penyewa->foto; 
            if (file_exists($thumbnailLg)) { 
                unlink($thumbnailLg); 
            } 
 
            // Hapus thumbnail md 
            $thumbnailMd = $directory . 'thumb_md_' . $penyewa->foto; 
            if (file_exists($thumbnailMd)) { 
                unlink($thumbnailMd); 
            } 
 
            // Hapus thumbnail sm 
            $thumbnailSm = $directory . 'thumb_sm_' . $penyewa->foto; 
            if (file_exists($thumbnailSm)) { 
                unlink($thumbnailSm); 
            } 
        } 
 
        // Hapus foto produk lainnya di tabel foto_produk 
        $fotoPenyewas = FotoPenyewa::where('penyewa_id', $id)->get(); 
        foreach ($fotoPenyewas as $fotoPenyewa) { 
            $fotoPath = $directory . $fotoPenyewa->foto; 
            if (file_exists($fotoPath)) { 
                unlink($fotoPath); 
            } 
            $fotoPenyewa->delete(); 
        } 
 
        $penyewa->delete(); 
 
        return redirect()->route('backend.penyewa.index')->with('success', 'Data berhasil dihapus');
    }

    public function formPenyewa() 
    { 
        return view('backend.v_penyewa.form', [ 
            'judul' => 'Laporan Data Penyewa', 
        ]); 
    } 
 
    // Method untuk Cetak Laporan Produk 
    public function cetakPenyewa(Request $request) 
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
        $query =  Penyewa::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('penyewa_id', 'desc'); 

    $penyewa = $query->get(); 
    return view('backend.v_penyewa.cetak', [ 
        'judul' => 'Laporan Penyewa', 
        'tanggalAwal' => $tanggalAwal, 
        'tanggalAkhir' => $tanggalAkhir, 
        'cetak' => $penyewa 
    ]); 
   } 
}
