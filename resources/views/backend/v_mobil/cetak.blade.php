<style> 
    table { 
        border-collapse: collapse; 
        width: 100%; 
        border: 1px solid #ccc; 
    } 
 
    table tr td { 
        padding: 6px; 
        font-weight: normal; 
        border: 1px solid #ccc; 
    } 
 
    table th { 
        border: 1px solid #ccc; 
    } 
</style> 
<table> 
    <!-- <tr> 
        <td align="center"> 
            <img src="{{ asset('images/header.png') }}" width="50%"> 
        </td> 
    </tr> --> 
    <tr> 
        <td align="left"> 
            Perihal : {{ $judul }} <br> 
            Tanggal Awal: {{ $tanggalAwal }} s/d Tanggal Akhir: {{ $tanggalAkhir }} 
        </td> 
    </tr> 
</table> 
<p></p> 
<table> 
    <thead> 
        <tr> 
            <th>No</th> 
            <th>Status</th>
            <th>Merk Mobil</th>
            <th>Jenis Mobil</th> 
            <th>No Polisi</th> 
            <th>Harga Sewa</th> 
            <th>Denda Keterlambatan</th>
            <th>Foto</th>               
        </tr> 
    </thead> 

    <tbody> 
        @foreach ($cetak as $row) 
        <tr> 
            <td> {{ $loop->iteration }}</td> 
            <td> 
                @if ($row->status ==1) 
                <span class="badge badge-success"></i> 
                    Tersedia</span> 
                @elseif($row->status ==0) 
                <span class="badge badge-secondary"></i> 
                    Tidak Tersedia</span> 
                @endif 
            </td> 
            <td> {{ $row->merk->merk_mobil }} </td> 
            <td> {{ $row->jenis_mobil }} </td> 
            <td>{{ $row->nopolisi }}</td>
            <td> Rp. {{ number_format($row->harga, 0, ',', '.') }}/ Hari </td> 
            <td> Rp. {{ number_format($row->total_denda, 0, ',', '.') }}/ Hari </td> 
            <td> <!-- Menampilkan Foto Mobil -->
                {{-- {{ $row->foto }} --}}
                <img src="{{ asset('storage/img-mobil/' . $row->foto) }}" alt="Foto Mobil" width="100" height="auto">
            </td>
           
        </tr> 
        @endforeach 
    </tbody> 
</table> 

<script> 
    window.onload = function() { 
        printStruk(); 
    } 
 
    function printStruk() { 
        window.print(); 
    } 
</script> 