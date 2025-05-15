@foreach ($barang_kembali as $data)
    <tr data-id="{{ $data->id_retur }}" class="table-row" data-url="/retur">
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
                                <x-link data-id="{{ $data->id_retur }}" label="Ubah" icon="fas fa-edit "
                                    class="dropdown-item ubah" url="/retur/edit" parameters="{{ $data->id_retur }}" />
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
            {{ $loop->iteration + $barang_kembali->perPage() * ($barang_kembali->currentPage() - 1) }}
        </td>
        <td class="align-middle text-center">
            {{-- load gambar live in table with php clean --}}
            {{-- @foreach (explode(',', $data->path) as $img)
                <img src="{{ asset($img) }}" class="img-thumbnail img-responsive" alt="{{ $img }}">
            @endforeach --}}
            <x-link data-data="{{ $data->image }}" icon="fas fa-eye" class="text-decoration-none image-view" />
        </td>
        <td class="align-middle">{{ Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
        <td class="align-middle">{{ $data->kode_retur }}</td>
        <td class="nama_barang align-middle ">{{ ucwords($data->barang->nama_barang) }}</td>
        <td class="nama_pelanggan align-middle text-start">{{ ucwords($data->pelanggan->nama) }}</td>
        <td class="align-middle">{{ ucwords($data->supplier->nama ?? '-') }}</td>
        <td class="align-middle ">{{ $data->jumlah }}</td>
        <td class="align-middle">{{ ucwords($data->tipe_retur) }}
        </td>
        <td class="align-middle ">
            @if ($data->status_pergantian == 'diganti')
                <span class="badge bg-success text-light">Diganti</span>
            @elseif ($data->status_pergantian == 'tidak_diganti')
                <span class="badge bg-danger text-light">Tidak Diganti</span>
            @elseif ($data->status_pergantian == 'diperbaiki')
                <span class="badge bg-info text-light">Diperbaiki</span>
            @endif
        </td>

        <td class="align-middle text-start">{{ $data->alasan }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="12" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
