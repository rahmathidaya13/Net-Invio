@props(['name', 'text' => null, 'options' => [], 'selected' => old($name), 'disabled' => ''])
@php
    $selectClass = 'form-select';
    if ($errors->has($name)) {
        $selectClass .= ' is-invalid';
    }
@endphp
<select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $selectClass]) }} name="{{ $name }}"
    id="{{ $name }}">
    @if ($text)
        <option value="" {{ $selected === null ? 'selected' : '' }}>{{ $text }}</option>
    @endif

    @foreach ($options as $key => $label)
        <option value="{{ $key }}" {{ $selected === $key ? 'selected' : '' }}>{{ ucwords($label) }}</option>
    @endforeach
</select>
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        {{ $message }}
    </div>
@enderror
