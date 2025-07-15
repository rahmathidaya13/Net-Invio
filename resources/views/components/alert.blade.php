@props([
    'type' => 'info',
    'message' => null,
    'duration' => 5,
])
@php
    $icons = [
        'success' => 'fas fa-check-circle text-success',
        'info' => 'fas fa-info-circle text-info',
        'danger' => 'fas fa-times-circle text-white',
        'warning' => 'fas fa-exclamation-circle text-warning',
    ];

    $iconClass = $icons[$type] ?? '';
    $uniqueId = 'alert-' . uniqid();
@endphp

<div id="{{ $uniqueId }}" class="alert alert-{{ $type }} fw-bold" role="alert" style="font-size: 16px;"
    data-duration="{{ $duration }}" {{ $attributes }}>
    @if ($iconClass)
        <i class="{{ $iconClass }} me-2"></i>
    @endif
    <span>{{ $message ?? $slot }}</span>
</div>

<script>
    $(document).ready(function() {
        const alertEl = $("#{{ $uniqueId }}");
        const duration = alertEl.data("duration");
        setTimeout(() => {
            alertEl.fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, duration * 1000);
    });
</script>
