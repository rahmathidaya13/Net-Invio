@props(['url' => '#', 'parameters' => null, 'label' => null, 'icon' => null])
<a href="{{ url($url, $parameters) }}" {{ $attributes }}>
    @if ($icon)
        <small><i class="{{ $icon }}"></i>
        </small>
    @endif
    {{ $label ?? $slot }}
</a>
