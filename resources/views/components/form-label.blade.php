@props(['for' => null, 'value', 'class' => 'form-label'])
<label for="{{ $for }}" {{ $attributes }} {{ $attributes->merge(['class' => $class]) }}>
    {{ $value ?: $slot }}
</label>
