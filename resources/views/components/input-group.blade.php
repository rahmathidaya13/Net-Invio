@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'iconLeft' => null,
    'iconRight' => null,
])

@php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<div class="input-group">
    @if ($iconLeft)
        <span class="input-group-text rounded-0"><i class="{{ $iconLeft }}"></i></span>
    @endif
    <input type="{{ $type }}" {{ $attributes->merge(['class' => $inputClass]) }}
        id="{{ $name }}" name="{{ $name }}" value="{{ $type !== 'password' ? old($name, $value) : '' }}">
    @if ($iconRight)
        <span class="input-group-text rounded-0"><i class="{{ $iconRight }}"></i></span>
    @endif
</div>
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </div>
@enderror
