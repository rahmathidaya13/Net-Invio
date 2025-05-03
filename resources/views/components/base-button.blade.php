@props(['label' => null, 'type' => 'submit', 'icon' => null, 'block' => false, 'variant' => 'primary'])
@php
    $classes = "btn btn-$variant rounded-0";
    if ($block) {
        $classes .= ' w-100';
    }
@endphp
<button {{ $attributes->merge(['class' => $classes]) }} type="{{ $type }}">
    @if ($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $label ?? $slot }}
</button>
