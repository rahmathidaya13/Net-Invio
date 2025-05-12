@foreach ($supplier as $data)
    <tr data-id="{{ $data->id_supplier }}" class="table-row" data-url="/supplier">
        @if (Gate::any(['edit', 'delete']))
            <td class="align-middle px-3 ">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm shadow-sm border-dark" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"> </i>
                    </button>

                    <ul class="dropdown-menu">
                        @can('edit')
                            <li>
                                <x-link label="Ubah" icon="fas fa-edit" class="dropdown-item" url="/supplier/edit"
                                    parameters="{{ $data->id_supplier }}" />
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
        <td class="align-middle text-center">
            {{ $loop->iteration + $supplier->perPage() * ($supplier->currentPage() - 1) }}
        </td>
        <td class="nama_supplier align-middle">{{ ucwords($data->nama) }}</td>
        <td class="kontak align-middle">{{ $data->kontak }}</td>
        <td class="email align-middle">{{ $data->email }}</td>
        <td class="align-middle">{{ $data->alamat }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
