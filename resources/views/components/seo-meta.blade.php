@php
    // Проверяем настройки индексации
    $indexingSettings = \App\Models\IndexingSettings::current();
    $globalIndexingDisabled = !$indexingSettings->global_indexing_enabled;

    // Проверяем индексацию конкретной страницы
    $pageIndexingDisabled = isset($isPageIndexed) && !$isPageIndexed;

    // Если глобально отключено ИЛИ страница отключена - не индексируем
    $noIndex = $globalIndexingDisabled || $pageIndexingDisabled;
@endphp

{{-- Отключение индексации --}}
@if ($noIndex)
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="bingbot" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="yandex" content="noindex, nofollow, noarchive, nosnippet">
@else
    <meta name="robots" content="index, follow">
@endif

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
    <meta property="og:site_name" content="ИстокиЯ - Студия йоги">

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
    <meta name="description" content="Профессиональная студия йоги ИстокиЯ в Москве">
    <meta property="og:title" content="ИстокиЯ - Студия йоги">
    <meta property="og:description" content="Профессиональная студия йоги ИстокиЯ в Москве">
    <meta property="og:image" content="{{ asset('/images/og-default.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:site_name" content="ИстокиЯ - Студия йоги">
@endif

<meta name="yandex-verification" content="fc4ba4d3bd46a5ee" />

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    // Подавляем ошибки WebSocket для Яндекс.Метрики
    (function() {
        const originalError = console.error;
        console.error = function() {
            const args = Array.from(arguments);
            const message = args.join(' ');
            // Игнорируем ошибки WebSocket от Яндекс.Метрики
            if (message.includes('solid.ws') || message.includes('mc.yandex')) {
                return;
            }
            originalError.apply(console, arguments);
        };
    })();

    // Отложенная загрузка Яндекс.Метрики после полной загрузки страницы
    window.addEventListener('load', function() {
        setTimeout(function() {
            (function(m, e, t, r, i, k, a) {
                m[i] = m[i] || function() {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) {
                    if (document.scripts[j].src === r) {
                        return;
                    }
                }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a
                    .parentNode.insertBefore(
                        k, a)
            })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id=105122403', 'ym');

            ym(105122403, 'init', {
                ssr: true,
                webvisor: true,
                clickmap: true,
                ecommerce: "dataLayer",
                accurateTrackBounce: true,
                trackLinks: true
            });
        }, 2000); // Задержка 2 секунды после загрузки страницы для минимизации TBT
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/105122403" style="position:absolute; left:-9999px;" alt="" />
    </div>
</noscript>
<!-- /Yandex.Metrika counter -->
<!-- SmartCaptcha загружается ленивым образом через компонент yandex-captcha -->
