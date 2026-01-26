{{-- основной favicon (использует storage URL или запасной asset) --}}
@php
    // Надёжный URL фавикона: приоритет - $setting->favicon_url, затем локальный запасной файл
    $favicon = $setting->favicon_url ?? asset('images/favicon-32x32-1.png');
@endphp
<link rel="icon" href="{{ $favicon }}">
<link rel="shortcut icon" href="{{ $favicon }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon }}">
<link rel="apple-touch-icon" href="{{ $favicon }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
