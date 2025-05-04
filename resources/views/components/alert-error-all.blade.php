@props([
    'type' => 'danger', // info, success, danger, warning, dll
    'title' => null,
])
@php
    $icons = [
        'success' => 'fas fa-check-circle text-success',
        'info' => 'fas fa-info-circle text-info',
        'danger' => 'fas fa-times-circle text-white',
        'warning' => 'fas fa-exclamation-circle text-warning',
    ];

    $iconClass = $icons[$type] ?? '';
@endphp
@if ($errors->any())
    <div class="alert alert-{{ $type }}" role="alert">
        @if ($iconClass)
            <h5 class="alert-heading"><i class="{{ $iconClass }} "></i> {{ $title }}</h5>
        @endif
        <ul class="align-items-center">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
