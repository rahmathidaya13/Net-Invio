<x-mail::message>

{{-- Header Nama Aplikasi --}}
<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="margin: 0; font-weight: 700; color: #2c3e50; font-size: 24px;">
        {{ config('app.name') }}
    </h2>
    <hr style="border-top: 2px solid #ccc; width: 80px; margin: 10px auto;">
</div>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Oops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Salam hormat'),<br>
<b>{{ config('app.name') }}</b>
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Jika kamu mengalami masalah saat menekan tombol \":actionText\", salin dan tempel tautan berikut ke browser kamu:",
    [
        'actionText' => $actionText,
    ]
)
<br><span style="word-break: break-all;">{{ $displayableActionUrl }}</span>
</x-slot:subcopy>
@endisset

</x-mail::message>
