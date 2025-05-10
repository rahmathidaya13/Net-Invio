@foreach ($stok as $data)
    <tr data-id="{{ $data->id_stok }}" class="table-row" data-url="/stok">
        <td class="align-middle px-3 ">

            <div class="dropdown">
                <button class="btn btn-light btn-sm shadow-sm border-dark" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"> </i>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <x-link label="Ubah" icon="fas fa-edit" class="dropdown-item" url="/stok/edit"
                            parameters="{{ $data->id_stok }}" />
                    </li>
                    <li>
                        <x-link data-data="{{ $data }}" icon="fas fa-trash" label="Hapus"
                            class="dropdown-item hapus" />
                    </li>
                </ul>
            </div>
        </td>
        <td class="align-middle text-center">
            {{ $loop->iteration + $stok->perPage() * ($stok->currentPage() - 1) }}
        </td>
        <td class="align-middle">{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
        <td class="align-middle">{{ $data->no_warehouse }}</td>
        <td class="nama_Barang align-middle text-start">{{ ucwords($data->barang->nama_barang) }}</td>
        <td class="align-middle">{{ $data->jumlah_barang }}</td>
        <td class="align-middle text-start text-center">{{ ucwords($data->lokasi) }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
