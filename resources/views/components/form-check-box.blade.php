@props(['label', 'name', 'checked' => false])
@php
    $inputClass = 'form-check-input';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp
<div class="form-check mb-0">
    <input type="checkbox" {{ $attributes->merge(['class' => $inputClass]) }} id="{{ $name }}"
        name="{{ $name }}" {{ old($name, $checked) ? 'checked' : '' }}>
    <label class="form-check-label mx-2" for="{{ $name }}">
        {{ $label ?? $slot }}
    </label>
</div>
