@props([
    'type' => 'info', // info, success, danger, warning, dll
    'icon' => null,
    'message' => null,
])
@php
    $icons = [
        'success' => 'fas fa-check-circle text-success',
        'info' => 'fas fa-info-circle text-info',
        'danger' => 'fas fa-times-circle text-danger',
        'warning' => 'fas fa-exclamation-circle text-warning',
    ];

    $iconClass = $icon ?? ($icons[$type] ?? '');
@endphp
<div class="alert alert-{{ $type }} fw-bold" role="alert" style="font-size: 16px;" {{ $attributes }}>
    @if ($iconClass)
        <i class="{{ $iconClass }} me-2"></i>
    @endif
    <span>{{ $message ?? $slot }}</span>
</div>
