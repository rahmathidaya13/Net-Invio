@props(['name', 'text' => 'Pilih salah satu', 'options' => [], 'selected' => old($name)])
@php
    $selectClass = 'form-select';
    if ($errors->has($name)) {
        $selectClass .= ' is-invalid';
    }
@endphp
<select {{ $attributes->merge(['class' => $selectClass]) }} name="{{ $name }}" id="{{ $name }}">
    <option value="" disabled {{ $selected === null ? 'selected' : '' }}>{{ $text }}</option>

    @foreach ($options as $key => $label)
        <option value="{{ $key }}" {{ $selected === $key ? 'selected' : '' }}>{{ ucwords($label) }}</option>
    @endforeach
</select>
@error($name)
    <div class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </div>
@enderror
