@props(['url' => '#', 'label', 'icon' => null])
<a href="{{ $url }}" {{ $attributes }}>
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $label ?? $slot }}
</a>
