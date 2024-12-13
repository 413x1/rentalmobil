@extends('backend.v_layouts.app') 
@section('content') 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <form class="form-horizontal" action="{{ route('backend.penyewaan.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="card-body"> 
                        <h4 class="card-title"> {{$judul}} </h4> 
                        <div class="row"> 
                            <div class="col-md-4"> 
                                <!-- User -->
                                <div class="form-group"> 
                                    <label>User</label> 
                                    <select class="form-control @error('user') is-invalid @enderror" name="user_id" id="user_id"> 
                                        <option value="" selected>--Pilih user--</option> 
                                        @foreach ($user as $k) 
                                            <option value="{{ $k->user_id }}"> {{ $k->nama }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('user_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div> 

                                <!-- Penyewa -->
                                <div class="form-group"> 
                                    <label>Penyewa</label> 
                                    <select class="form-control @error('penyewa') is-invalid @enderror" name="penyewa_id" id="penyewa_id"> 
                                        <option value="" selected>--Pilih Penyewa--</option> 
                                        @foreach ($penyewa as $k) 
                                            <option value="{{ $k->penyewa_id }}"> {{ $k->nama }} </option> 
                                        @endforeach 
                                    </select> 
                                    @error('penyewa_id') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <!-- Jenis Mobil -->
                                <div class="form-group"> 
                                    <label>Jenis Mobil</label> 
                                    <select class="form-control @error('mobil') is-invalid @enderror" name="mobil_id" id="mobil_id"> 
                                        <option value="" selected>--Pilih Jenis Mobil--</option> 
                                        @foreach ($mobil as $k) 
                                            <option value="{{ $k->mobil_id }}"
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

                                <!-- No Polisi -->
                                <div class="form-group"> 
                                    <label>No Polisi</label> 
                                    <input type="text" id="no_polisi" class="form-control" readonly>
                                </div>

                                <!-- Tanggal Sewa -->
                                <div class="form-group"> 
                                    <label>Tanggal Sewa</label> 
                                    <input type="date" name="sewa" id="sewa" class="form-control @error('sewa') is-invalid @enderror" placeholder="Masukkan Tanggal Sewa"> 
                                    @error('sewa') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <!-- Tanggal Kembali -->
                                <div class="form-group"> 
                                    <label>Tanggal Kembali</label> 
                                    <input type="date" name="kembali" id="kembali" class="form-control @error('kembali') is-invalid @enderror" placeholder="Masukkan Tanggal Kembali"> 
                                    @error('kembali') 
                                    <span class="invalid-feedback alert-danger" role="alert"> 
                                        {{ $message }} 
                                    </span> 
                                    @enderror 
                                </div>

                                <div class="form-group">
                                    <label for="">Jumlah Hari Keterlambatan</label>
                                    <input type="numerik" id="hari_terlambat" name="hari_terlambat" class="form-control" value="0">
                                </div>

                                <div class="form-group"> 
                                    <label>Harga Sewa</label> 
                                    <input type="text" id="harga_sewa" class="form-control" readonly>
                                </div>
                                <div class="form-group"> 
                                    <label>Denda Harian</label> 
                                    <input type="text" id="total_denda" class="form-control" readonly>
                                </div>

                                <div class="form-group"> 
                                    <button class="btn btn-sm btn-secondary check-all">Check</button>
                                </div>

                                <!-- Total Harga Sewa -->
                                <div class="form-group">
                                    <label>Total Harga Sewa</label>
                                    <input type="text" id="total_harga" class="form-control" readonly>
                                </div>

                                <!-- Total Denda -->
                                {{-- <div class="form-group">
                                    <label>Total Denda</label>
                                    <input type="text" id="total_denda" class="form-control" readonly>
                                </div> --}}

                                <!-- Total Harga + Denda -->
                                <div class="form-group">
                                    <label>Total Harga + Denda</label>
                                    <input type="text" id="total_harga_denda" class="form-control" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="border-top"> 
                        <div class="card-body"> 
                            <button type="submit" class="btn btn-primary">Simpan</button> 
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
@endsection


@section('scripts')
<script type="text/javascript">
    $( document ).ready(function() {
        
        $('#mobil_id').change(function() {
            let harga = $(this).find(':selected').data('harga')
            let nomor_polisi = $(this).find(':selected').data('nomor_polisi')
            let total_denda = $(this).find(':selected').data('total_denda')

            $('#harga_sewa').val(harga);
            $('#no_polisi').val(nomor_polisi);
            $('#total_denda').val(total_denda);
        })


        $('.check-all').on('click', function (e) {
            e.preventDefault();
            validate();
            calculateTotal();
        })

    });

function validate() {
    let user = $('#user_id').val() || false
    let penyewa = $('#penyewa_id').val() || false
    let mobil = $('#mobil_id').val() || false
    let sewa = $('#sewa').val() || false
    let kembali = $('#kembali').val() || false
    let keterlambatan = $('#hari_terlambat').val() || false


    if(!user) {
        alert('User kosong')
        return
    }
    if(!penyewa) {
        alert('Penyewa kosong')
        return
    }
    if(!mobil) {
        alert('Mobil kosong')
        return
    }
    if(!sewa) {
        alert('Tanggal sewa kosong')
        return
    }
    if(!kembali) {
        alert('Tanggal pengembalian kosong')
        return
    }
    if(!keterlambatan) {
        alert('Keterlambatan kosong')
        return
    }

}

function calculateTotal() {
    let sewa = $('#sewa').val() || false;
    let kembali = $('#kembali').val() || false;
    let harga = $('#harga_sewa').val() || 0;
    let keterlambatan = $('#hari_terlambat').val() || 0;  

    if (sewa && kembali && harga) {
        
        let sewaDate = new Date(sewa);
        let kembaliDate = new Date(kembali);
        let diffTime = Math.abs(kembaliDate - sewaDate);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if(diffDays < 1) {
            diffDays = 1;
        }

        let totalHarga = diffDays * harga;
        $('#total_harga').val(totalHarga);

        let denda = $('#total_denda').val() || 0;
        let totalDendaKeterlambatan = 0;
        if (keterlambatan > 0 && denda > 0) {
            totalDendaKeterlambatan = denda * keterlambatan; // Contoh denda 1000 per hari
        }        

        var totalHargaDenda = totalHarga + totalDendaKeterlambatan;
        $('#total_harga_denda').val(totalHargaDenda);
    }
}
</script>
@endsection
