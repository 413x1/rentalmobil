@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <div class="card-body"> 
                    <h4 class="card-title">{{ $judul }}</h4> 
                    <div class="row"> 
 
                            <div class="form-group"> 
                                <label>Nama Penyewa</label> 
                                <input type="text" name="nama" value="{{ old('nama', $show->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama Penyewa" disabled> 
                                @error('nama') 
                                <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                </span> 
                                @enderror 
                            </div> 
 
                            <div class="form-group"> 
                                <label>Foto Utama</label> <br> 
                                <img src="{{ asset('storage/img-foto/' . $show->foto) }}" class="foto-preview" width="100%"> 
                            </div> 
                        </div> 
 
                        <div class="col-md-6"> 
                            <label>Foto Tambahan</label> 
                            <div id="foto-container"> 
                                <div class="row"> 
                                    @foreach($show->fotoPenyewa as $gambar) 
                                    <div class="col-md-8"> 
                                        <img src="{{ asset('storage/img-foto/' . $gambar->foto) }}" width="100%"> 
                                    </div> 
                                    <div class="col-md-4"> 
                                        <form action="{{ route('backend.foto_penyewa.destroy', $gambar->fotopenyewa_id) }}" method="post"> 
                                            @csrf 
                                            @method('delete') 
                                            <button type="submit" class="btn btn-danger">Hapus</button> 
                                        </form> 
                                    </div> 
 
                                    @endforeach 
                                </div> 
                                <br> 
                            </div> 
                            <button type="button" class="btn btn-primary add-foto mt-2">Tambah Foto</button> 
                        </div> 
 
                    </div> 
                </div> 
 
                <div class="border-top"> 
                    <div class="card-body"> 
                        <a href="{{ route('backend.penyewa.index') }}"> 
                            <button type="button" class="btn btn-secondary">Kembali</button> 
                        </a> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
 
<!-- contentAkhir -->
@endsection 
 
<script> 
    document.addEventListener('DOMContentLoaded', function() { 
        const fotoContainer = document.getElementById('foto-container'); 
        const addFotoButton = document.querySelector('.add-foto'); 
 
        addFotoButton.addEventListener('click', function() { 
            const fotoRow = document.createElement('div'); 
            fotoRow.classList.add('form-group', 'row'); 
            fotoRow.innerHTML = ` 
                <form action="{{ route('backend.foto_penyewa.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="col-md-12"> 
                        <input type="hidden" name="penyewa_id" value="{{ $show->id }}"> 
                        <input type="file" name="foto_penyewa[]" class="form-control @error('foto_penyewa') is-invalid @enderror"> 
                        <button type="submit" class="btn btn-success">Simpan</button> 
                    </div> 
                </form> 
            `; 
            fotoContainer.appendChild(fotoRow); 
        }); 
    }); 
</script> 