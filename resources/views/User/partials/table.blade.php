@foreach ($user as $data)
    <tr id="user_column_{{ $data->id }}">
        <td class="align-middle text-center">{{ $loop->iteration + $user->perPage() * ($user->currentPage() - 1) }}
        </td>
        <td class="nama align-middle">{{ ucwords($data->name) }}</td>
        <td class="email align-middle">{{ $data->email }}</td>
        <td class="align-middle">{{ $data->role }}</td>
        <td class="align-middle">
            @if ($data->can_view)
                <span class="badge bg-info me-1">Lihat</span>
            @endif
            @if ($data->can_add)
                <span class="badge bg-success me-1">Tambah</span>
            @endif
            @if ($data->can_edit)
                <span class="badge bg-warning text-dark me-1">Ubah</span>
            @endif
            @if ($data->can_delete)
                <span class="badge bg-danger me-1">Hapus</span>
            @endif
        </td>
        <td class="align-middle">
            <x-link icon="fas fa-edit" class="btn btn-warning btn-sm" url="{{ route('user.edit', $data->id) }}" />
            <x-form url="/user/destroy" :parameters="$data->id" method="delete">
                <x-base-button class="btn-sm" type="submit" icon="fas fa-trash" variant="danger" />
            </x-form>
        </td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
