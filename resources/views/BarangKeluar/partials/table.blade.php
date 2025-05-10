@foreach ($barang_keluar as $data)
    <tr data-id="{{ $data->id_barang_keluar }}" class="table-row" data-url="/outbound">
        <td class="align-middle px-3 ">

            <div class="dropdown">
                <button class="btn btn-light btn-sm shadow-sm border-dark" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"> </i>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <x-link data-id="{{ $data->id_barang }}" label="Ubah" icon="fas fa-edit "
                            class="dropdown-item ubah" url="/outbound/edit"
                            parameters="{{ $data->id_barang_keluar }}" />
                    </li>
                    <li>
                        <x-link data-data="{{ $data }}" icon="fas fa-trash" label="Hapus"
                            class="dropdown-item hapus" />
                    </li>
                </ul>
            </div>
        </td>
        <td class="align-middle text-center">
            {{ $loop->iteration + $barang_keluar->perPage() * ($barang_keluar->currentPage() - 1) }}
        </td>
        <td class="align-middle">{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
        <td class="nama_barang align-middle text-start">
            {{ ucwords($data->barang->nama_barang) }}
        </td>
        <td class="nama_pelanggan align-middle">{{ ucwords($data->pelanggan->nama ?? '-') }}</td>
        <td class="align-middle">{{ ucwords($data->tujuan) }}</td>
        <td class="align-middle ">{{ $data->jumlah }}</td>
        <td class="align-middle ">{{ ucwords($data->satuan) }}</td>
        <td class="align-middle ">{{ $data->keterangan }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
