@foreach ($pelanggan as $data)
    <tr data-id="{{ $data->id_pelanggan }}" class="table-row" data-url="/pelanggan">
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
                                <x-link label="Ubah" icon="fas fa-edit" class="dropdown-item" url="/pelanggan/edit"
                                    parameters="{{ $data->id_pelanggan }}" />
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
            {{ $loop->iteration + $pelanggan->perPage() * ($pelanggan->currentPage() - 1) }}
        </td>
        <td class="align-middle">{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
        <td class="align-middle">{{ $data->no_identitas }}</td>
        <td class="nama_pelanggan align-middle">{{ ucwords($data->nama) }}</td>
        <td class="align-middle">{{ ucwords($data->jenis_kelamin) }}</td>
        <td class="nohp align-middle">{{ $data->nohp }}</td>
        <td class="align-middle">{{ $data->email }}</td>
        <td class="align-middle">{{ $data->alamat }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
