@props(['type' => 'text', 'name', 'label', 'value' => null, 'readonly' => ''])

@php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<div class="mb-3 row align-items-center">
    <label for="{{ $name }}" class="col-sm-2 col-form-label form-label">{{ $label }}</label>
    <div class="col-sm-5">
        <input autocomplete="off" {{ $readonly ? 'readonly' : '' }} type="{{ $type }}"
            {{ $attributes->merge(['class' => $inputClass]) }} class="form-control" id="{{ $name }}"
            name="{{ $name }}" value="{{ $type !== 'password' ? old($name, $value) : '' }}">
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
