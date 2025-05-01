@props(['url' => null, 'parameters' => null, 'method' => null])
<form enctype="multipart/form-data" {{ $attributes }} method="POST" action="{{ url($url, $parameters) }}" role="form">
    @csrf
    @if ($method)
        @method(Str::upper($method))
    @endif
    {{ $slot }}
</form>
