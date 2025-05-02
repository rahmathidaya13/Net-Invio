@foreach ($barang as $data)
    <tr id="item_column_{{ $data->id_barang }}">
        <td class="align-middle text-center">{{ $loop->iteration + $barang->perPage() * ($barang->currentPage() - 1) }}
        </td>
        <td class="kode align-middle">{{ $data->kode_barang }}</td>
        <td class="nama_barang align-middle">{{ ucwords($data->nama_barang) }}</td>
        <td class="align-middle">{{ $data->jenis }}</td>
        <td class="align-middle">{{ $data->merek }}</td>
        <td class="tipe_model align-middle">{{ $data->tipe_model }}</td>
        <td class="serial_number align-middle">{{ $data->serial_number }}</td>
        <td class="align-middle">{{ $data->satuan }}</td>
        <td class="align-middle">{{ $data->keterangan }}</td>
        <td class="align-middle">
            <x-link icon="fas fa-edit" class="btn btn-warning btn-sm" url="/barang/edit"
                parameters="{{ $data->id_barang }}" />
            <x-form url="/barang/destroy" :parameters="$data->id_barang" method="delete">
                <x-base-button class="btn-sm" type="submit" icon="fas fa-trash" variant="danger" />
            </x-form>
        </td>
    </tr>
@endforeach
@empty($data)
    <tr>
        <td colspan="10" class="text-center">Tidak ada data ditemukan</td>
    </tr>
@endempty
