<h1>DAFTAR PELANGGAN TERDATA</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No.Identitas</th>
            <th>Nama Pelanggan</th>
            <th>Jenis Kelamin</th>
            <th>No.Handphone</th>
            <th>Email</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelanggan as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $data->no_identitas }}</td>
                <td>{{ ucwords($data->nama) }}</td>
                <td>{{ ucwords($data->jenis_kelamin) }}</td>
                <td>{{ $data->nohp }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->alamat }}</td>
            </tr>
        @endforeach
        @empty($data)
            <tr>
                <td colspan="7" style="text-align: center">Data tidak ditemukan</td>
            </tr>
        @endempty
    </tbody>
</table>
