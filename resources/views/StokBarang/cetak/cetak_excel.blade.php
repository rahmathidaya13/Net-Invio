<h1>LAPORAN DATA STOK BARANG</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No.Warehouse</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Lokasi/Tempat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stok as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $data->no_warehouse }}</td>
                <td>{{ $data->barang->nama_barang }}</td>
                <td>{{ $data->jumlah_barang }}</td>
                <td>{{ $data->lokasi }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
