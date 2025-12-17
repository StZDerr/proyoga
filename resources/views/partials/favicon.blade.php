{{-- основной favicon (использует сторедж URL или запасной asset) --}}
<link rel="icon" href="{{ $setting->favicon_url ?? asset('images/logo/logoYOGAwhite.svg') }}">
{{-- 32x32 fallback --}}
<link rel="icon" type="image/png" sizes="32x32"
    href="{{ $setting->favicon_url ?? asset('images/logo/logoYOGAwhite.svg') }}">
