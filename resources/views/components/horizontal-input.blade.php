@props(['type' => 'text', 'name', 'label', 'value' => null])
<div class="mb-3 row align-items-center">
    <label for="{{ $name }}" class="col-sm-2 col-form-label form-label">{{ $label }}</label>
    <div class="col-sm-5">
        <input type="{{ $type }}" {{ $attributes }}
            class="form-control @error($name)
            is-invalid
        @enderror "
            id="{{ $name }}" name="{{ $name }}"
            value="{{ $type !== 'password' ? old($name, $value) : '' }}">
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
