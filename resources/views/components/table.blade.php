@props(['header' => [], 'theadColor' => 'success', 'tbodyId' => null])
<table {{ $attributes->merge(['class' => 'table']) }}>
    <thead class="table-{{ $theadColor }}">
        <tr>
            <th class="text-center" scope="col">Aksi</th>
            @foreach ($header as $row)
                <th scope="col">{{ $row }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody id="{{ $tbodyId }}">
        {{ $slot }}
    </tbody>
</table>
