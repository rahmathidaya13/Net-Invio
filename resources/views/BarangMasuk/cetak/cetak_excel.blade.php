<h1>LAPORAN DATA BARANG MASUK</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nota</th>
            <th>No.Warehouse</th>
            <th>Nama Barang</th>
            <th>Supplier</th>
            <th>Sumber</th>
            <th>Pembeli</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Lokasi Penyimpanan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang_masuk as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $data->nota }}</td>
                <td>{{ $data->no_warehouse }}</td>
                <td>{{ $data->barang->nama_barang }}</td>
                <td>{{ ucwords($data->supplier->nama ?? '-') }}</td>
                <td>{{ $data->sumber }}</td>
                <td>{{ ucwords($data->pembeli) }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ number_format((int) $data->harga, 0, ',', '.') }}</td>
                <td>{{ ucwords($data->lokasi) }}</td>
                <td>{{ ucwords($data->keterangan) }}</td>
            </tr>
        @endforeach
        @empty($data)
            <tr>
                <td colspan="11" style="text-align: center">Data tidak ditemukan</td>
            </tr>
        @endempty
    </tbody>
</table>
