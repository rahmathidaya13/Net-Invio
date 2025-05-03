@foreach ($barang as $data)
    <tr data-id="{{ $data->id_barang }}" class="table-row" data-url="/barang">
        <td class="align-middle px-3 ">
            <x-link data-data="{{ $data }}" icon="fas fa-trash" class="btn btn-danger btn-sm hapus px-3 bg-gradient" />
            <x-form class="d-none" id="deleted_{{ $data->id_barang }}" url="/barang/destroy" :parameters="$data->id_barang"
                method="delete">
            </x-form>
            <x-link icon="fas fa-edit" class="btn btn-warning btn-sm px-3 bg-gradient" url="/barang/edit"
                parameters="{{ $data->id_barang }}" />
        </td>
        <td class="align-middle text-center">{{ $loop->iteration + $barang->perPage() * ($barang->currentPage() - 1) }}
        </td>
        <td class="kode align-middle">{{ $data->kode_barang }}</td>
        <td class="nama_barang align-middle">{{ ucwords($data->nama_barang) }}</td>
        <td class="align-middle">{{ $data->jenis }}</td>
        <td class="align-middle">{{ $data->merek }}</td>
        <td class="tipe_model align-middle">{{ $data->tipe_model }}</td>
        <td class="serial_number align-middle">{{ $data->serial_number }}</td>
        <td class="align-middle text-center">{{ $data->satuan }}</td>
        <td class="align-middle">{{ $data->keterangan }}</td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
