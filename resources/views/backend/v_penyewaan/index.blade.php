@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 

<div class="row"> 
    <div class="col-12"> 
        <a href="{{ route('backend.penyewaan.create') }}"> 
            <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Penyewaan</button> 
        </a>
        <p></p>
        <div class="card"> 
            <div class="card-body"> 
                <h5 class="card-title"> {{$judul}} </h5> 
                <div class="table-responsive"> 
                    <table id="zero_config" class="table table-striped table-bordered"> 
                        <thead> 
                            <tr> 
                                <th>No</th> 
                                <th>Nama Penyewa</th> 
                                <th>Nama Jenis Mobil</th>
                                <th>No Polisi</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Harga Sewa</th> 
                                <th>Total Harga</th>
                                <th>Total Denda</th>
                                <th>Total Harga + Denda</th>
                                <th>Nama User</th>
                                <th>Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach ($index as $row) 
                            <tr> 
                                <td> {{ $loop->iteration }} </td> 
                                <td> {{$row->penyewa->nama ?? 'Tidak tersedia' }}</td> 
                                <td> {{$row->mobil->jenis_mobil}} </td>
                                <td> {{$row->mobil->nopolisi }}</td> 
                                <td> {{$row->sewa}} </td> 
                                <td> {{$row->kembali}} </td>  

                                {{-- Total Harga Sewa --}}
                                <td> Rp. {{ number_format($row->harga, 0, ',', '.') }} / Hari</td>

                                {{-- Hitung Total Harga berdasarkan durasi sewa --}}
                                @php
                                    $sewaDate = \Carbon\Carbon::parse($row->sewa);
                                    $kembaliDate = \Carbon\Carbon::parse($row->kembali);
                                    $diffInDays = $sewaDate->diffInDays($kembaliDate);
                                    $totalHarga = $row->harga * $diffInDays;
                                @endphp
                                <td> Rp. {{ number_format($totalHarga, 0, ',', '.') }} </td>

                                <td> Rp. {{ number_format($row->total_denda, 0, ',', '.') }} </td>

                                {{-- Total Harga + Denda --}}
                                <td> Rp. {{ number_format($totalHarga + $totalDenda, 0, ',', '.') }} </td>
                                <td> {{$row->user->nama ?? 'Tidak tersedia'}} </td>
                                <td> 
                                    <a href="{{ route('backend.penyewaan.edit', $row->penyewaan_id) }}" title="Ubah Data"> 
                                        <button type="button" class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Ubah</button> 
                                    </a> 
                                    <form method="POST" action="{{ route('backend.penyewaan.destroy', $row->penyewaan_id) }}" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="penyewaan" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td> 
                            </tr> 
                            @endforeach 
                        </tbody> 
                    </table> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<!-- contentAkhir --> 
@endsection
