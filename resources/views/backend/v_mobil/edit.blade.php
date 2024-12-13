@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <form action="{{ route('backend.mobil.update', $edit->mobil_id) }}" method="post" enctype="multipart/form-data"> 
                    @method('put') 
                    @csrf 
 
                    <div class="card-body"> 
                        <h4 class="card-title"> {{$judul}} </h4> 
                        <div class="row"> 
 
                            <div class="col-md-4"> 
                                <div class="form-group"> 
                                    <label>Foto</label> 
                                    {{-- view image --}} 
                                    @if ($edit->foto) 
                                    <img src="{{ asset('storage/img-mobil/' . $edit->foto) }}" class="foto-preview" width="100%"> 
                                    <p></p> 
                                    @else 
                                    <img src="{{ asset('storage/img-mobil/img-default.jpg') }}" class="foto-preview" width="100%"> 
                                    <p></p> 
                                    @endif 
                                    {{-- file foto --}} 
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()"> 
                                    @error('foto') 
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div> 
                                    @enderror 
                                </div> 
                            </div> 
 
                            <div class="col-md-8"> 
                                <div class="form-group"> 
                                    <label>Status</label> 
                                    <select name="status" class="form-control @error('status') is-invalid @enderror"> 
                                        <option value="" {{ old('status', $edit->status) == '' ? 'selected' : '' }}>- Pilih Status -</option> 
                                        <option value="1" {{ old('status', $edit->status) == '1' ? 'selected' : '' }}> Tersedia</option> 
                                        <option value="0" {{ old('status', $edit->status) == '0' ? 'selected' : '' }}> Tidak Tersedia</option> 
                                    </select> 
                                    @error('status') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                                     
                                <div class="form-group"> 
                                    <label>Merk Mobil</label> 
                                    <select name="merk_id" class="form-control @error('merk_id') is-invalid @enderror"> 
                                        <option value="" selected> - Pilih Merk Mobil - </option> 
                                        @foreach ($merk as $row) 
                                        @if (old('merk_id', $edit->merk_id) == $row->merk_id) 
                                        <option value="{{ $row->merk_id }}" selected> {{ $row->merk_mobil }} </option> 
                                        @else 
                                        <option value="{{ $row->merk_id }}"> {{ $row->nama_type }} </option> 
                                        @endif 
                                        @endforeach 
                                    </select> 
                                    @error('merk_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                                     
                                <div class="form-group"> 
                                    <label>Nama Jenis Mobil</label> 
                                    <input type="text" name="jenis_mobil" value="{{ old('jenis_mobil',$edit->jenis_mobil) }}" class="form-control @error('jenis_mobil') is-invalid @enderror" placeholder="Masukkan Nama Jenis Mobil"> 
                                    @error('jenis_mobil') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                    {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                                     
                                {{-- <div class="form-group"> 
                                    <label>Deskripsi</label><br> 
                                    <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" id="ckeditor">{{ old('detail',$edit->detail) }}</textarea> 
                                    @error('detail') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>  --}}
 
                                <div class="form-group"> 
                                    <label>Denda Kterlambatan</label> 
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="total_denda" value="{{ old('total_denda',$edit->total_denda) }}" class="form-control @error('total_denda') is-invalid @enderror" placeholder="Masukkan Denda Keterlambatan"> 
                                    @error('total_denda') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                                <div class="form-group"> 
                                    <label>Harga Sewa</label> 
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="harga" value="{{ old('harga',$edit->harga) }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Masukkan Harga Produk"> 
                                    @error('harga') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
 
                                <div class="form-group"> 
                                    <label>NO Polisi</label> 
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="nopolisi" value="{{ old('nopolisi', $edit->nopolisi) }}" class="form-control @error('nopolisi') is-invalid @enderror" placeholder="Masukkan No Polisi"> 
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
                            <button type="submit" class="btn btn-primary">Perbaharui</button> 
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
