@props(['header' => [], 'theadColor' => 'success', 'tbodyId' => null])
<table {{ $attributes->merge(['class' => 'table']) }}>
    <thead class="table-{{ $theadColor }}">
        <tr>
            @foreach ($header as $row)
                <th scope="col">{{ $row }}</th>
            @endforeach
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody id="{{ $tbodyId }}">
        {{ $slot }}
    </tbody>
</table>
