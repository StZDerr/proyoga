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
    @if ($pageMeta['og_image'])
        <meta property="og:image" content="{{ asset($pageMeta['og_image']) }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">

    {{-- Twitter Card теги --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageMeta['og_title'] }}">
    @if ($pageMeta['og_description'])
        <meta name="twitter:description" content="{{ $pageMeta['og_description'] }}">
    @endif
    @if ($pageMeta['og_image'])
        <meta name="twitter:image" content="{{ asset($pageMeta['og_image']) }}">
    @endif
@else
    <title>ProYoga - Студия йоги</title>
    <meta name="description" content="Профессиональная студия йоги ProYoga">
@endif
