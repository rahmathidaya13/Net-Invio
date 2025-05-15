<h1>LAPORAN DATA BARANG KELUAR</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kode Barang Keluar</th>
            <th>Nama Barang</th>
            <th>Nama Pelanggan</th>
            <th>Tujuan</th>
            <th>Barang Keluar</th>
            <th>Satuan </th>
            <th>Petugas</th>
            <th>Lokasi Penyimpanan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang_keluar as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $data->kode_barang_keluar }}</td>
                <td>{{ $data->barang->nama_barang ?? '-' }}</td>
                <td>{{ ucwords($data->pelanggan->nama ?? '-') }}</td>
                <td>{{ ucwords($data->tujuan) }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ $data->satuan }}</td>
                <td>{{ ucwords($data->petugas) }}</td>
                <td>{{ ucwords($data->lokasi) }}</td>
                <td>{{ ucwords($data->keterangan) }}</td>
            </tr>
        @endforeach
        @empty($data)
            <tr>
                <td colspan="10" style="text-align: center">Data tidak ditemukan</td>
            </tr>
        @endempty
    </tbody>
</table>
