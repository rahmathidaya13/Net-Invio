
<h1>DAFTAR BARANG</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Merek</th>
            <th>Tipe Model</th>
            <th>Serial Number</th>
            <th>Satuan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $data)
            <tr>
                <td>{{ $data->kode_barang }}</td>
                <td>{{ $data->nama_barang }}</td>
                <td>{{ $data->jenis }}</td>
                <td>{{ $data->merek }}</td>
                <td>{{ $data->tipe_model }}</td>
                <td>{{ $data->serial_number }}</td>
                <td>{{ $data->satuan }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

