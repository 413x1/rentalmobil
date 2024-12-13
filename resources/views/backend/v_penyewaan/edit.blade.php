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
                                    <select class="form-control @error('user') is-invalid @enderror" name="user_id" id="user_id"> 
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
                                    <select class="form-control @error('penyewa') is-invalid @enderror" name="penyewa_id" id="penyewa_id"> 
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
                                    <select class="form-control @error('mobil') is-invalid @enderror" name="mobil_id" id="mobil_id">
                                        @foreach ($mobil as $k) 
                                        <option value="{{ $k->mobil_id }}" {{ old('mobil_id', $edit->mobil_id) == $k->mobil_id ? 'selected' : '' }}
                                            data-harga="{{ $k->harga }}"
                                            data-nomor_polisi="{{ $k->nopolisi }}"
                                            data-total_denda="{{ $k->total_denda }}"
                                        > {{ $k->jenis_mobil }} </option> 
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
                                    <input type="date" name="sewa" id="sewa" class="form-control @error('sewa') is-invalid @enderror" placeholder="Masukkan Tanggal Sewa" oninput="calculateHarga()"> 
                                    @error('sewa') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="form-group"> 
                                    <label>Tanggal Kembali</label> 
                                    <input type="date" name="kembali" id="kembali" class="form-control @error('kembali') is-invalid @enderror"
                                        placeholder="Masukkan Tanggal Kembali" oninput="calculateHarga()"> 
                                    @error('kembali') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <div class="form-group"> 
                                    <label>Harga Sewa</label> 
                                    <input type="text" id="harga_sewa" class="form-control" value="{{$edit->harga}}" readonly>
                                </div>
                                
                                @php
                                    $keterlambatan = $edit->total_denda / $edit->mobil->total_denda
                                @endphp
                                <div class="form-group"> 
                                    <label>Denda Harian</label> 
                                    <input type="text" id="total_denda" class="form-control" value="{{$edit->mobil->total_denda}}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="">Jumlah Hari Keterlambatan</label>
                                    <input type="numerik" id="hari_terlambat" name="hari_terlambat" class="form-control" value="{{ $keterlambatan }}">
                                </div>

                                <div class="form-group"> 
                                    <label>Nomor Polisi</label> 
                                    <input type="text" id="no_polisi" class="form-control" value="{{$edit->mobil->nopolisi}}" readonly>
                                </div>
                            </div>

                            <!-- Add Total Harga and Denda -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="text" name="total_harga" id="total_harga" class="form-control" value="{{ old('total_harga', $totalHarga) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Total Denda</label>
                                    <input type="text" name="denda" id="denda" class="form-control" value="{{ old('denda', $edit->total_denda) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Total Harga + Denda</label>
                                    <input type="text" name="total_harga_denda" id="total_harga_denda" class="form-control" value="{{ $totalHarga + $edit->total_denda }}" readonly>
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

@endsection


@section('scripts')
<script type="text/javascript">

var old_sewa = "{{$edit->sewa}}";
var old_kembali = "{{$edit->kembali}}";

$(document).ready(function() {

    $('#sewa').val(old_sewa);
    $('#kembali').val(old_kembali);


    $('#mobil_id').change(function() {
        changeMobil(this);
    })

    $('#hari_terlambat').on('input', function() {
        calculateHarga();

        let dendaHari = $('#mobil_id').find(':selected').data('total_denda');
        let hari = $(this).val();

        $('#denda').val(dendaHari * hari);
        
    })
})

function changeMobil(thisEl) {
    let harga = $(thisEl).find(':selected').data('harga')
    let nomor_polisi = $(thisEl).find(':selected').data('nomor_polisi')
    let total_denda = $(thisEl).find(':selected').data('total_denda')
    let terlambat = $('#hari_terlambat').val();

    $('#harga_sewa').val(harga);
    $('#no_polisi').val(nomor_polisi);
    $('#total_denda').val(total_denda);
    $('#denda').val(terlambat * total_denda)

    calculateHarga();
}


function calculateHarga()
{
    let sewa_date = $('#sewa').val() || false;
    let kembali_date = $('#kembali').val() || false;
    let terlambat = $('#hari_terlambat').val() || 0;
    let harga = parseInt($('#harga_sewa').val() || 0);

    if(!sewa_date) {
        alert("Tanggal sewa kosong")
        return
    }

    if(!kembali_date) {
        alert("Tanggal kembali kosong")
        return
    }

    if(harga && sewa_date && kembali_date)
    {
        let sewaDate = new Date(sewa_date);
        let kembaliDate = new Date(kembali_date);
        let diffTime = Math.abs(kembaliDate - sewaDate);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if(diffDays < 1) {
            diffDays = 1;
        }

        let totalHarga = diffDays * harga;
        $('#total_harga').val(totalHarga);

        let denda = $('#total_denda').val() || 0;
        let totalDendaKeterlambatan = 0;
        if (terlambat > 0 && denda > 0) {
            totalDendaKeterlambatan = denda * terlambat; // Contoh denda 1000 per hari
        }        

        var totalHargaDenda = totalHarga + totalDendaKeterlambatan;
        $('#total_harga_denda').val(totalHargaDenda);
    }
}

</script>
@endsection