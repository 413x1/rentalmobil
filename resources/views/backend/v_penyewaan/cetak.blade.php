
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
            <th>Nama Jenis Mobil</th>
            <th>No Polisi</th>
            <th>Tanggal Sewa</th>
            <th>Tanggal Kembali</th>
            <th>Harga Sewa</th> 
            <th>Total Harga</th>
            <th>Total Denda</th>
            <th>Total Harga + Denda</th>
            <th>Nama User</th>
        </tr> 
    </thead> 
    <tbody>
        @foreach ($cetak as $row)
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
            <td> Rp. {{ number_format($totalHarga, 0, ',', '.') }} / Hari </td>

            {{-- Denda --}}
            @php
                $today = \Carbon\Carbon::now();
                $lateDays = $kembaliDate->diffInDays($today, false); // false to get negative value for early return
                $dendaPerHari = 50000; // Misalnya denda Rp 50.000 per hari
                $totalDenda = 0;

                if ($lateDays > 0) {
                    $totalDenda = $lateDays * $dendaPerHari;
                }
            @endphp
            <td> Rp. {{ number_format($totalDenda, 0, ',', '.') }} </td>

            {{-- Total Harga + Denda --}}
            <td> Rp. {{ number_format($totalHarga + $totalDenda, 0, ',', '.') }} </td>
            <td> {{$row->user->nama ?? 'Tidak tersedia'}} </td>
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