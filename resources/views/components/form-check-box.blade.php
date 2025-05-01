@props(['label', 'name', 'checked' => false])
<div class="form-check mb-0">
    <input class="form-check-input @error($name)
        is-invalid
    @enderror " type="checkbox" {{ $attributes }}
        id="{{ $name }}" name="{{ $name }}" {{ old($name, $checked) ? 'checked' : '' }}>
    <label class="form-check-label mx-2" for="{{ $name }}">
        {{ $label ?? $slot }}
    </label>
</div>
