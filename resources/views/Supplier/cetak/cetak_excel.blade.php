<h1>DAFTAR SUPPLIER TERDATA</h1>
<h1>PT NEDLINK TELEKOMUNIKASI</h1>
<br>
<table>
    <thead>
        <tr>
            <th>Nama Supplier</th>
            <th>Kontak</th>
            <th>Email</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($supplier as $data)
            <tr>
                <td>{{ ucwords($data->nama) }}</td>
                <td>{{ $data->kontak }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->alamat }}</td>
            </tr>
        @endforeach
        @empty($data)
            <tr>
                <td colspan="4" style="text-align: center">Data tidak ditemukan</td>
            </tr>
        @endempty
    </tbody>
</table>
