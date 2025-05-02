@props([
    'type' => 'info', // info, success, danger, warning, dll
    'message' => null,
])
@php
    $icons = [
        'success' => 'far fa-check-circle text-success',
        'info' => 'far fa-info-circle text-info',
        'danger' => 'far fa-times-circle text-white',
        'warning' => 'far fa-exclamation-circle text-warning',
    ];

    $iconClass = $icon ?? ($icons[$type] ?? '');
@endphp

<div class="alert alert-{{ $type }} fw-bold" role="alert" style="font-size: 16px;" {{ $attributes }}>
    @if ($iconClass)
        <i class="{{ $iconClass }} me-2"></i>
    @endif
    <small>{{ $message ?? $slot }}</small>
</div>
