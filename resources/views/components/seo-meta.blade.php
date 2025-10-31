{{-- Мета-теги для SEO --}}
@if (isset($pageMeta))
    <title>{{ $pageMeta['title'] }}</title>
    @if ($pageMeta['description'])
        <meta name="description" content="{{ $pageMeta['description'] }}">
    @endif
    @if ($pageMeta['keywords'])
        <meta name="keywords" content="{{ $pageMeta['keywords'] }}">
    @endif

    {{-- Open Graph теги --}}
    <meta property="og:title" content="{{ $pageMeta['og_title'] }}">
    @if ($pageMeta['og_description'])
        <meta property="og:description" content="{{ $pageMeta['og_description'] }}">
    @endif

    {{-- OG Image с fallback --}}
    @php
        $ogImage = $pageMeta['og_image'] ?? '/images/og-default.jpg';
        // Проверяем, существует ли файл
        if (!empty($pageMeta['og_image']) && !file_exists(public_path($pageMeta['og_image']))) {
            $ogImage = '/images/og-default.jpg';
        }
    @endphp
    <meta property="og:image" content="{{ asset($ogImage) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="ИстокиЯ - Студия йоги"">

    {{-- Twitter Card теги --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageMeta['og_title'] }}">
    @if ($pageMeta['og_description'])
        <meta name="twitter:description" content="{{ $pageMeta['og_description'] }}">
    @endif
    <meta name="twitter:image" content="{{ asset($ogImage) }}">
    <meta name="twitter:site" content="@istokiya_yoga">
@else
    <title>ИстокиЯ - Студия йоги</title>
    <meta name="description" content="Профессиональная студия йоги ProYoga">
    <meta property="og:title" content="ИстокиЯ - Студия йоги">
    <meta property="og:description" content="Профессиональная студия йоги ProYoga">
    <meta property="og:image" content="{{ asset('/images/og-default.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
@endif
