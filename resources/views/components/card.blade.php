@props([
    'title' => null,
    'footer' => null,
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'titleClass' => '',
])
<div {{ $attributes->merge(['class' => 'card mb-3']) }}>
    @if ($title && $headerClass)
        <div class="card-header {{ $headerClass }}">
            @if ($title)
                <h5 class="card-title {{ $titleClass }} mb-0">{{ $title }}</h5>
            @endif
        </div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
    @if ($footer)
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>
