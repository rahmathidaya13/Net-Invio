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
        <td class="align-middle flex-wrap justify-content-center">
            {{-- Display user permissions --}}
            @php
                $permissions = [
                    'can_view' => ['label' => 'Lihat', 'class' => 'bg-info'],
                    'can_add' => ['label' => 'Tambah', 'class' => 'bg-success'],
                    'can_edit' => ['label' => 'Ubah', 'class' => 'bg-warning text-dark'],
                    'can_delete' => ['label' => 'Hapus', 'class' => 'bg-danger'],
                    'can_import' => ['label' => 'Import', 'class' => 'bg-info'],
                    'can_download' => ['label' => 'Unduh', 'class' => 'bg-success'],
                ];
                $hasAny = false;
            @endphp
            @foreach ($permissions as $key => $info)
                @if (!empty($data->$key))
                    @php $hasAny = true; @endphp
                    <span class="badge {{ $info['class'] }} me-1">{{ $info['label'] }}</span>
                @endif
            @endforeach
            {{-- Display 'Tidak Ada Otorisasi' if no permissions are set --}}
            @unless ($hasAny)
                <span class="badge bg-secondary me-1">Tidak Ada Otorisasi</span>
            @endunless
        </td>

    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
