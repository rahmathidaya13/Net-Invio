@props(['name', 'value' => null])

@php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<textarea name="{{ $name }}" id="{{ $name }}" cols="4" rows="4"
    {{ $attributes->merge(['class' => $inputClass]) }}>{{ old($name, $value) }}
</textarea>
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        {{ $message }}
    </div>
@enderror
