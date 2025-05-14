@foreach ($user as $data)
    <tr id="user_column_{{ $data->id }}">
        <td class="align-middle">
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-eye"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <x-link icon="fas fa-edit" class="dropdown-item" label="Ubah"
                            url="{{ route('user.edit', $data->id) }}" />
                    </li>

                    <li>
                        <x-link data-data="{{ $data }}" icon="fas fa-trash" label="Hapus"
                            class="dropdown-item hapus" />
                    </li>
                </ul>
            </div>
        </td>
        <td class="align-middle text-center">{{ $loop->iteration + $user->perPage() * ($user->currentPage() - 1) }}
        </td>
        <td class="nama align-middle">{{ ucwords($data->name) }}</td>
        <td class="email align-middle">{{ $data->email }}</td>
        <td class="align-middle">{{ ucwords($data->role) }}</td>
        <td class="align-middle">
            @if ($data->can_view)
                <span class="badge bg-info me-1">Lihat</span>
            @elseif($data->can_add)
                <span class="badge bg-success me-1">Tambah</span>
            @elseif($data->can_edit)
                <span class="badge bg-warning text-dark me-1">Ubah</span>
            @elseif($data->can_delete)
                <span class="badge bg-danger me-1">Hapus</span>
            @else
                <span class="badge bg-secondary me-1">Tidak Ada Otorisasi</span>
            @endif
        </td>

    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
