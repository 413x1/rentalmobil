@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <form action="{{ route('backend.penyewaan.update', $edit->penyewaan_id) }}" method="post" enctype="multipart/form-data"> 
                    @method('put') 
                    @csrf 
                    <div class="card-body"> 
                        <h4 class="card-title"> {{$judul}} </h4> 
                        <div class="row"> 
                            <div class="col-md-4"> 
                                <div class="form-group"> 
                                    <label>User</label> 
                                    <select class="form-control @error('user') is-invalid @enderror" name="user_id"> 
                                        <option value="" selected>--Pilih user--</option> 
                                        @foreach ($user as $k) 
                                        <option value="{{ $k->user_id }}" {{ old('user_id', $edit->user_id) == $k->user_id ? 'selected' : '' }}> {{ $k->nama }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('user_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 

                                <div class="form-group"> 
                                    <label>Penyewa</label> 
                                    <select class="form-control @error('penyewa') is-invalid @enderror" name="penyewa_id"> 
                                        <option value="" selected>--Pilih Penyewa--</option> 
                                        @foreach ($penyewa as $k) 
                                        <option value="{{ $k->penyewa_id }}" {{ old('penyewa_id', $edit->penyewa_id) == $k->penyewa_id ? 'selected' : '' }}> {{ $k->nama }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('penyewa_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <div class="form-group"> 
                                    <label>Jenis Mobil</label> 
                                    <select class="form-control @error('mobil') is-invalid @enderror" name="mobil_id"> 
                                        <option value="" selected>--Pilih Jenis Mobil--</option> 
                                        @foreach ($mobil as $k) 
                                        <option value="{{ $k->mobil_id }}" {{ old('mobil_id', $edit->mobil_id) == $k->mobil_id ? 'selected' : '' }}> {{ $k->jenis_mobil }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('mobil_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 

                                <!-- Tanggal Sewa -->
                                <div class="form-group"> 
                                    <label>Tanggal Sewa</label> 
                                    <input type="date" name="sewa" id="sewa" class="form-control @error('sewa') is-invalid @enderror" placeholder="Masukkan Tanggal Sewa" oninput="calculateTotal()"> 
                                    @error('sewa') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="form-group"> 
                                    <label>Tanggal Kembali</label> 
                                    <input type="date" name="kembali" id="kembali" class="form-control @error('kembali') is-invalid @enderror" placeholder="Masukkan Tanggal Kembali" oninput="calculateTotal()"> 
                                    @error('kembali') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <div class="form-group"> 
                                    <label>Harga Sewa</label> 
                                    <select class="form-control @error('mobil') is-invalid @enderror" name="mobil_id">
                                        <option value="" selected>--Harga Sewa--</option>
                                        @foreach ($mobil as $k)
                                            <option value="{{ $k->mobil_id }}">{{ $k->harga }}</option>
                                        @endforeach
                                    </select>
                                    @error('mobil_id')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group"> 
                                    <label>No Polisi</label> 
                                    <select class="form-control @error('mobil') is-invalid @enderror" name="mobil_id"> 
                                        <option value="" selected>--Pilih No Polisi--</option> 
                                        @foreach ($mobil as $k) 
                                        <option value="{{ $k->mobil_id }}" {{ old('mobil_id', $edit->mobil_id) == $k->id ? 'selected' : '' }}> {{ $k->nopolisi }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('mobil_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 
                            </div>

                            <!-- Add Total Harga and Denda -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ old('total_harga', $totalHarga) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Denda</label>
                                    <input type="text" name="denda" id="denda" class="form-control" value="{{ old('denda', $totalDenda) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="border-top"> 
                            <div class="card-body"> 
                                <button type="submit" class="btn btn-primary">Perbaharui</button> 
                                <a href="{{ route('backend.penyewaan.index') }}"> 
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

<script>
    function calculateTotal() {
        var sewa = document.getElementById('sewa').value;
        var kembali = document.getElementById('kembali').value;
        var harga = document.getElementById('harga').value;

        if (sewa && kembali && harga) {
            var sewaDate = new Date(sewa);
            var kembaliDate = new Date(kembali);
            var diffTime = Math.abs(kembaliDate - sewaDate);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            var totalHarga = diffDays * harga;
            document.getElementById('total_harga').value = totalHarga;

            var denda = 0;
            if (kembaliDate > sewaDate) {
                denda = diffDays * 1000; // Contoh denda 1000 per hari
            }
            document.getElementById('total_denda').value = denda;

            var totalHargaDenda = totalHarga + denda;
            document.getElementById('total_harga_denda').value = totalHargaDenda;
        }
    }
</script>
@endsection