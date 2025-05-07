@props(['items' => []])
<div class="pagetitle">
    <nav class="d-lg-flex flex flex-wrap flex-row flex-col justify-content-between align-items-center py-lg-3 pt-3">
        {{-- title --}}
        <h3 class="fw-bold"><i class="@yield('icon')"></i> <span>@yield('text')</span> @yield('breadcrumb')</h3>

        <ol class="breadcrumb align-items-center small">
            <li class="breadcrumb-item">
                <x-link class="text-decoration-none" label="Home" url="/home" />
            </li>
            @foreach ($items as $item)
                @if ($loop->last)
                    <li class="breadcrumb-item active">{{ $item['text'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <x-link class="text-decoration-none" label="{{ $item['text'] }}" url="{{ $item['url'] }}" />
                    </li>
                @endif
            @endforeach

        </ol>

    </nav>
</div>
