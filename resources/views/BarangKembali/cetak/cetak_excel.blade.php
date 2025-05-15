<h1>LAPORAN DATA BARANG KEMBALI</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kode Retur</th>
            <th>Barang</th>
            <th>Pelanggan</th>
            <th>Supplier</th>
            <th>Jumlah Retur</th>
            <th>Tipe Retur</th>
            <th>Status</th>
            <th>Alasan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang_kembali as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $data->kode_retur }}</td>
                <td>{{ ucwords($data->barang->nama_barang) }}</td>
                <td>{{ ucwords($data->pelanggan->nama ?? '-') }}</td>
                <td>{{ ucwords($data->supplier->nama ?? '-') }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ ucwords($data->tipe_retur) }}</td>
                <td>{{ ucwords($data->status_pergantian) }}</td>
                <td>{{ ucwords($data->alasan) }}</td>
            </tr>
        @endforeach
        @empty($data)
            <tr>
                <td colspan="9" style="text-align: center">Data tidak ditemukan</td>
            </tr>
        @endempty
    </tbody>
</table>
