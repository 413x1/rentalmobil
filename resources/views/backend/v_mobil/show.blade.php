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
 
                        <div class="col-md-6"> 
                            <div class="form-group"> 
                                <label>Merk</label> 
                                <select name="merk_id" class="form-control @error('merk_id') is-invalid @enderror" disabled> 
                                    <option value="" selected> - Pilih Merk - </option> 
                                    @foreach ($merk as $row) 
                                    <option value="{{ $row->id }}" {{ old('merk_id', $show->merk_id) == $row->id ? 'selected' : '' }}> 
                                        {{ $row->merk_mobil }} 
                                    </option> 
                                    @endforeach 
                                </select> 
                                @error('merk_id') 
                                <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                </span> 
                                @enderror 
                            </div> 
 
                            <div class="form-group"> 
                                <label>Nama Mobil</label> 
                                <input type="text" name="jenis_mobil" value="{{ old('jenis_mobil', $show->jenis_mobil) }}" class="form-control @error('jenis_mobil') is-invalid @enderror" placeholder="Masukkan Jenis Mobil" disabled> 
                                @error('jenis_mobil') 
                                <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                </span> 
                                @enderror 
                            </div> 
 
                            {{-- <div class="form-group"> 
                                <label>Detail</label> 
                                <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" id="ckeditor" disabled>{{ old('detail', $show->detail) }}</textarea> 
                                @error('detail') 
                                <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                </span> 
                                @enderror 
                            </div>  --}}
                            <div class="form-group"> 
                                <label>Foto Utama</label> <br> 
                                <img src="{{ asset('storage/img-mobil/' . $show->foto) }}" class="foto-preview" width="100%"> 
                            </div> 
                        </div> 
 
                        <div class="col-md-6"> 
                            <label>Foto Tambahan</label> 
                            <div id="foto-container"> 
                                <div class="row"> 
                                    @foreach($show->fotoMobil as $gambar) 
                                    <div class="col-md-8"> 
                                        <img src="{{ asset('storage/img-mobil/' . $gambar->foto) }}" width="100%"> 
                                    </div> 
                                    <div class="col-md-4"> 
                                        <form action="{{ route('backend.foto_mobil.destroy', $gambar->fotomobil_id) }}" method="post"> 
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
                        <a href="{{ route('backend.mobil.index') }}"> 
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
                <form action="{{ route('backend.foto_mobil.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="col-md-12"> 
                        <input type="hidden" name="mobil_id" value="{{ $show->id }}"> 
                        <input type="file" name="foto_mobil[]" class="form-control @error('foto_mobil') is-invalid @enderror"> 
                        <button type="submit" class="btn btn-success">Simpan</button> 
                    </div> 
                </form> 
            `; 
            fotoContainer.appendChild(fotoRow); 
        }); 
    }); 
</script> 