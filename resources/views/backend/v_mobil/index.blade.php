@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="row"> 
 
    <div class="col-12"> 
        <a href="{{ route('backend.mobil.create') }}"> 
            <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jenis Mobil</button> 
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
                                <th>Merk Mobil</th>
                                <th>Status</th>
                                <th>Jenis Mobil</th> 
                                <th>Harga Sewa</th> 
                                <th>Foto</th>
                                <th>No Polisi</th>
                                <th>Denda Keterlambatan</th>
                                <th>Aksi</th>                                
                            </tr> 
                        </thead> 
 
                        <tbody> 
                            @foreach ($index as $row) 
                            <tr> 
                                <td> {{ $loop->iteration }}</td> 
                                <td> {{ $row->merk->merk_mobil }} </td> 
                                <td> 
                                    @if ($row->status ==1) 
                                    <span class="badge badge-success"></i> 
                                        Tersedia</span> 
                                    @elseif($row->status ==0) 
                                    <span class="badge badge-secondary"></i> 
                                        Tidak Tersedia</span> 
                                    @endif 
                                </td> 
                                <td> {{ $row->jenis_mobil }} </td> 
                                <td> Rp. {{ number_format($row->harga, 0, ',', '.') }} /Hari </td> 
                                <td> <!-- Menampilkan Foto Mobil -->
                                    <img src="{{ asset('storage/img-mobil/' . $row->foto) }}" alt="Foto Mobil" width="100" height="auto">
                                </td>
                                    <td>{{ $row->nopolisi }}</td>
                                    {{-- Fungsi strip_tags() digunakan untuk menghapus semua tag HTML dari teks. --}}
                                    <td> Rp. {{ number_format($row->total_denda, 0, ',', '.') }} /Hari </td> 
                                <td> 
                                    <a href="{{ route('backend.mobil.edit', $row->mobil_id) }}" title="Ubah Data"> 
                                        <button type="button" class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Ubah</button> 
                                    </a> 
                                    {{-- <a href="{{ route('backend.mobil.show', $row->id) }}" title="Ubah Data">
                                        <button type="button" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Gambar</button> 
                                    </a> --}}
                                    <form method="POST" action="{{ route('backend.mobil.destroy', $row->mobil_id) }}" style="display: inline-block;"> 
                                        @method('delete') 
                                        @csrf 
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $row->jenis_mobil }}" title='Hapus Data'> 
                                            <i class="fas fa-trash"></i> Hapus</button> 
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