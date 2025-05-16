@props(['property' => null])
@error($property)
    <div class="invalid-feedback d-block" role="alert">
        {{ $message }}
    </div>
@enderror
