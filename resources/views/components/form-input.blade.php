@props(['type' => 'text', 'name', 'value'])

@php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<input {{ $attributes }} type="{{ $type }}" {{ $attributes->merge(['class' => $inputClass]) }}
    id="{{ $name }}" name="{{ $name }}" value="{{ $type !== 'password' ? old($name, $value) : '' }}">
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </div>
@enderror
