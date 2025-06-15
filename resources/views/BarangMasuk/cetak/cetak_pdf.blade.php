<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title> Laporan Barang Masuk</title>
    <style>
        /* set batas margin layout */
        @page {
            margin: 35px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            margin: 20px auto;
            margin-bottom: 20px;
            font-size: 12px;
            font-family: Arial, sans-serif;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            overflow: hidden;
        }

        th {
            background-color: #c2f8e2;
            /* Warna biru untuk header */
            color: #000000;
            font-weight: bold;
            text-transform: capitalize;
            padding: 10px;
            font-size: 12px;
        }

        td {
            background-color: #f9f9f9;
            color: #000000;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: start;
            vertical-align: middle;
            white-space: wrap;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-all;
            word-wrap: break-word;
        }

        tbody tr:nth-child(odd) td {
            background-color: #e6e6e6;
            color: #000000;
        }

        tbody tr:nth-child(even) td {
            background-color: #ffffff;
            color: #000000;
        }

        tbody tr td:nth-child(1),
        tbody tr td:nth-child(7),
        tbody tr td:nth-child(8) {
            text-align: center;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #c2f8e2;
            padding: 20px;
            /* border: 1px solid #000000; */
        }

        .header img {
            width: 200px;
            height: auto;
            position: absolute;
            padding: 1px;
            margin: 5px;
            margin-top: 15px;
            border: 1px solid #5e5e5e;

        }

        .header .title {
            flex-grow: 1;
            text-align: center;
            margin-top: 19px;
        }

        .header h1 {
            font-family: 'Arial', sans-serif;
            font-size: 22px;
            text-align: center;
            margin-bottom: 10px;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 15px;
        }

        .header h2 {
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            text-align: center;
            margin-bottom: 10px;
            color: #808080;
            line-height: 8px;
            padding-top: 0;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }

        .divider {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }

        /* tanda tangan dan validasi */
        .signature-container {
            text-align: right;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }

        .date {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .signature {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-align: right;
        }

        .username {
            margin-top: 60px;
            border-top: 1px solid black;
            display: inline-block;
            width: 200px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">
            <h1>LAPORAN DATA BARANG MASUK</h1>
            <h1>PT NEDLINK TELEKOMUNIKASI</h1>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Barang Masuk</th>
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
                    <td>{{ $data->kode_brg_masuk }}</td>
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

    <div class="divider"></div>
    {{-- validasi dan tanggal --}}
    <div class="signature-container">
        <div class="date">Pekanbaru, {{ \Carbon\Carbon::now()->translatedFormat('d/m/Y') }}</div>
        <div class="signature">
            <div class="username">Admin</div>
        </div>
    </div>


</body>

</html>
