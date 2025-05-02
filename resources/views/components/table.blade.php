@props(['header' => [], 'theadColor' => 'success', 'tbodyId' => null])
<table {{ $attributes->merge(['class' => 'table']) }} {{ $attributes }}>
    <thead class="table-{{ $theadColor }}">
        <tr>
            @foreach ($header as $row)
                <th scope="col">{{ $row }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody id="{{ $tbodyId }}">
        {{ $slot }}
    </tbody>
</table>
