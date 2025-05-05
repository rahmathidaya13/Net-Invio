@foreach ($barang_masuk as $data)
    <tr data-id="{{ $data->id_barang_masuk }}" class="table-row" data-url="/receiving">
        <td class="align-middle px-3 ">

            <div class="dropdown">
                <button class="btn btn-light btn-sm shadow-sm border-dark" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"> </i>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <x-link label="Ubah" icon="fas fa-edit" class="dropdown-item" url="/receiving/edit"
                            parameters="{{ $data->id_barang_masuk }}" />
                    </li>
                    <li>
                        <x-link data-data="{{ $data }}" icon="fas fa-trash" label="Hapus"
                            class="dropdown-item hapus" />
                    </li>
                </ul>
            </div>
        </td>
        <td class="align-middle text-center">
            {{ $loop->iteration + $barang_masuk->perPage() * ($barang_masuk->currentPage() - 1) }}
        </td>
        <td class="align-middle">{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
        <td class="nama_Barang align-middle text-start">{{ ucwords($data->barang->nama_barang) }}</td>
        <td class="align-middle">{{ $data->supplier->nama ?? '-' }}</td>
        <td class="align-middle text-start">{{ $data->sumber }}</td>
        <td class="align-middle text-start">{{ $data->pembeli }}</td>
        <td class="align-middle text-start">{{ $data->nota }}</td>
        <td class="align-middle text-start">{{ $data->jumlah }}</td>
        <td class="align-middle text-start">{{ $data->keterangan }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
