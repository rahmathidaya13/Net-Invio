@foreach ($barang as $data)
    <tr data-id="{{ $data->id_barang }}" class="table-row" data-url="/barang">
        @if (Gate::any(['delete', 'edit']))
            <td class="align-middle px-3 ">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm shadow-sm border-dark" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"> </i>
                    </button>

                    <ul class="dropdown-menu">
                        @can('edit')
                            <li>
                                <x-link label="Ubah" icon="fas fa-edit" class="dropdown-item" url="/barang/edit"
                                    parameters="{{ $data->id_barang }}" />
                            </li>
                        @endcan
                        @can('delete')
                            <li>
                                <x-link data-data="{{ $data }}" icon="fas fa-trash" label="Hapus"
                                    class="dropdown-item hapus" />
                            </li>
                        @endcan
                    </ul>
                </div>
            </td>
        @endif
        <td class="align-middle text-center">{{ $loop->iteration + $barang->perPage() * ($barang->currentPage() - 1) }}
        </td>
        <td class="kode align-middle">{{ $data->kode_barang }}</td>
        <td class="nama_barang align-middle">{{ ucwords($data->nama_barang) }}</td>
        <td class="align-middle">{{ $data->jenis }}</td>
        <td class="align-middle">{{ $data->merek }}</td>
        <td class="tipe_model align-middle">{{ $data->tipe_model }}</td>
        <td class="serial_number align-middle">{{ $data->serial_number }}</td>
        <td class="align-middle text-center">{{ ucwords($data->satuan) }}</td>
        <td class="align-middle">{{ $data->keterangan }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
