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
            <th>Nama Penyewa</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>No Identitas</th>
        </tr>
    </thead>  
<tbody>
    @foreach ($cetak as $row)
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