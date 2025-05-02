@props(['for' => null, 'value', 'class' => 'form-label'])
<label for="{{ $for }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $value ?? $slot }}
</label>
