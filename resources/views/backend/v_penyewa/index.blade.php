@extends('backend.v_layouts.app')
@section('content')
<!-- contentAwal -->

<div class="row">
    <div class="col-12">
    <a href="{{ route('backend.penyewa.create') }}">
    <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Penyewa</button>
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
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>No Identitas</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($index as $row)
                        <tr>
                        <td> {{ $loop->iteration }} </td>
                        <td> {{$row->nama}} </td>
                        <td> {{$row->email}} </td>
                        <td> {{ $row->telepon }}</td>
                        <td> {{ $row->alamat }}</td>
                        <td>
                            @if ($row->status == 1)
                            <span class="badge badge-success"></i>
                                Aktif</span>
                            @elseif($row->status == 0)
                            <span class="badge badge-secondary"></i>
                                NonAktif</span>
                            @endif
                        </td>
                        <td> {{ $row->nomor_identitas }}</td>
                        <td> <!-- Menampilkan Foto identitas -->
                            <img src="{{ asset('storage/img-foto/' . $row->foto) }}" alt="Foto identitas" width="100" height="auto">
                        </td>
                        <td>
                            <a href="{{ route('backend.penyewa.edit', $row->penyewa_id) }}" title="Ubah Data">
                                <button type="button" class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Ubah</button>
                            </a>
                            {{-- <a href="{{ route('backend.penyewa.show', $row->id) }}" title="Ubah Data">
                                <button type="button" class="btn btn-warning btn-sm"><i class="fas fa-plus"></i> Gambar</button> 
                            </a> --}}

                            <form method="POST" action="{{ route('backend.penyewa.destroy', $row->penyewa_id) }}" style="display: inline-block;">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $row->nama }}"  title='Hapus Data'> 
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
                       























