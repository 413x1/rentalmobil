@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <form class="form-horizontal" action="{{ route('backend.mobil.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="card-body"> 
                        <h4 class="card-title"> {{$judul}} </h4> 
                        <div class="row"> 
 
                            <div class="col-md-4"> 
                                <div class="form-group"> 
                                    <label>Foto Mobil</label> 
                                    <img class="foto-preview"> 
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()"> 
                                    @error('foto') 
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div> 
                                    @enderror 
                                </div> 
                            </div> 
 
                            <div class="col-md-8"> 
                                <div class="form-group"> 
                                    <label>Merk Mobil</label> 
                                    <select class="form-control @error('merk') is-invalid @enderror" name="merk_id"> 
                                        <option value="" selected>--Pilih Merk Mobil-</option> 
                                        @foreach ($merk as $k) 
                                        <option value="{{ $k->merk_id }}"> {{ $k->merk_mobil }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('merk_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
 
                                <div class="form-group"> 
                                    <label>Jenis Mobil</label> 
                                    <input type="text" name="jenis_mobil" value="{{ old('jenis_mobil') }}" class="form-control @error('jenis_mobil') is-invalid @enderror" placeholder="Masukkan Nama Jenis Mobil"> 
                                    @error('jenis_mobil') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
 
                                {{-- <div class="form-group"> 
                                    <label>Deskripsi</label><br> 
                                    <textarea name="detail" class="form-control @error('denda') is-invalid @enderror" id="ckeditor">{{ old('detail') }}</textarea> 
                                    @error('detail') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                         </span> 
                                        @enderror 
                                </div>  --}}
                                <div class="form-group"> 
                                    <label>Denda Keterlambatan</label> 
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="total_denda" value="{{ old('total_denda') }}" class="form-control @error('total_denda') is-invalid @enderror" placeholder="Masukkan Denda Keterlambatan"> 
                                    @error('total_denda') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                                     
                                                                    <div class="form-group"> 
                                                                        <label>Harga Sewa</label> 
                                                                        <input type="text" onkeypress="return hanyaAngka(event)" name="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga Produk"> 
                                                                        @error('harga') 
                                                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                                                            {{ $message }} 
                                                                        </span> 
                                                                        @enderror 
                                                                    </div> 
                                                                    <div class="form-group"> 
                                                                        <label>No Polisi</label> 
                                                                        <input type="text" onkeypress="return hanyaAngka(event)" name="nopolisi" value="{{ old('berat') }}" class="form-control @error('nopolisi') is-invalid @enderror" placeholder="Masukkan No Polisi"> 
                                                                        @error('nopolisi') 
                                                                        <span class="invalid-feedback alert-danger" role="alert"> 
                                                                            {{ $message }} 
                                                                        </span> 
                                                                        @enderror 
                                                                    </div> 
                                                                </div> 
                                                            </div> 
                                                        </div> 
                                                        <div class="border-top"> 
                                                            <div class="card-body"> 
                                                                <button type="submit" class="btn btn-primary">Simpan</button> 
                                                                    <a href="{{ route('backend.mobil.index') }}"> 
                                                                    <button type="button" class="btn btn-secondary">Kembali</button> 
                                                                </a> 
                                                            </div> 
                                                        </div> 
                                                    </form> 
                                                </div> 
                                            </div> 
                                        </div> 
                                    </div> 
                                     
                                    <!-- contentAkhir --> 
                                    @endsection 