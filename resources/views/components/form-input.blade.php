@props(['type' => 'text', 'name', 'value' => null, 'autocomplete' => 'off'])

@php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<input autocomplete="{{ $autocomplete }}" type="{{ $type }}" {{ $attributes->merge(['class' => $inputClass]) }}
    id="{{ $name }}" name="{{ $name }}" value="{{ $type !== 'password' ? old($name, $value) : '' }}">
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        {{ $message }}
    </div>
@enderror
