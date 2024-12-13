@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $judul }}</h4>
                    <form class="form-horizontal" action="{{ route('backend.penyewa.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Nama Penyewa -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Penyewa</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan Nama Penyewa">
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" placeholder="Masukkan Alamat Penyewa">
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Nomor Telepon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon">Nomor Telepon</label>
                                    <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" placeholder="Masukkan Nomor Telepon">
                                    @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                             <!-- Nomor Identitas -->
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_identitas">Nomor Identitas</label>
                                    <input type="text" name="nomor_identitas" class="form-control @error('nomor_identitas') is-invalid @enderror" value="{{ old('nomor_identitas') }}" placeholder="Masukkan Nomor Identitas">
                                    @error('nomor_identitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Identitas -->
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_identitas">Jenis Identitas</label>
                                    <select name="jenis_identitas" class="form-control @error('jenis_identitas') is-invalid @enderror">
                                        <option value="KTP" {{ old('jenis_identitas') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                        <option value="SIM" {{ old('jenis_identitas') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                        <option value="PASPOR" {{ old('jenis_identitas') == 'PASPOR' ? 'selected' : '' }}>PASPOR</option>
                                    </select>
                                    @error('jenis_identitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan Email Penyewa">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Foto KTP -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto Identitas</label>
                                    <img class="foto-preview">
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"  onchange="previewFoto()">
                                    @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Driver (Perlu Sopir) -->
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver">Butuh Sopir</label>
                                    <select name="driver" class="form-control @error('driver') is-invalid @enderror">
                                        <option value="0" {{ old('driver') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('driver') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    @error('driver')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Tambah Penyewa</button>
                                <a href="{{ route('backend.penyewa.index') }}">
                                    <button type="button" class="btn btn-secondary">Kembali</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contentAkhir -->
@endsection
