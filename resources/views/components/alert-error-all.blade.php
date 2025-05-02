@props([
    'type' => 'danger', // info, success, danger, warning, dll
    'icon' => null,
    'title' => null,
])
@php
    $icons = [
        'success' => 'fas fa-check-circle text-success',
        'info' => 'fas fa-info-circle text-info',
        'danger' => 'fas fa-times-circle text-success',
        'warning' => 'fas fa-exclamation-circle text-warning',
    ];

    $iconClass = $icon ?? ($icons[$type] ?? '');
@endphp
@if ($errors->any())
    <div class="alert alert-{{ $type }} d-flex align-items-start" role="alert">
        @if ($iconClass)
            <i class="{{ $iconClass }} me-2 mt-1 fs-4"></i>
        @endif
        @if ($title)
            <h5 class="alert-heading"> {{ $title }}</h5>
        @endif
        <ul class="align-items-center mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
