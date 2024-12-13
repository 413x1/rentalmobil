@extends('backend.v_layouts.app') 
@section('content') 
<!-- contentAwal --> 
 
<div class="row"> 
 
    <div class="col-12"> 
        <a href="{{ route('backend.merk.create') }}"> 
            <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Merk </button> 
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
                                <th>Nama Merk Mobil</th> 
                                <th>Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach ($index as $row) 
                            <tr> 
                                <td> {{ $loop->iteration }} </td> 
                                <td> {{$row->merk_mobil}} </td> 
                                <td> 
                                    <a href="{{ route('backend.merk.edit', $row->merk_id) }}" title="Ubah Data"> 
                                        <button type="button" class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Ubah</button> 
                                    </a> 
                                    <form method="POST" action="{{ route('backend.merk.destroy', $row->merk_id) }}" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $row->merk_mobil }}" title="Hapus Data">
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