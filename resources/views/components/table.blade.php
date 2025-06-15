@props(['header' => [], 'theadColor' => 'success', 'tbodyId' => null])
<table {{ $attributes->merge(['class' => 'table table-sticky']) }}>
    <thead class="table-{{ $theadColor }} table-striped">
        <tr>
            @if (Gate::any(['edit', 'delete', 'onlyAdmin']))
                <th class="text-center" scope="col">
                    <i class="bi bi-list text-dark"> </i>
                </th>
            @endif
            @foreach ($header as $row)
                <th scope="col">{{ $row }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody id="{{ $tbodyId }}">
        {{ $slot }}
    </tbody>
</table>
