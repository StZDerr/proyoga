<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $article->title }} - ИстокиЯ</title>
    <meta name="description" content="{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 160) }}">

    @include('partials.favicon')

    {{-- Preconnect для Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Асинхронная загрузка шрифтов --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">

    {{-- Fallback для браузеров без JS --}}
    <noscript>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
            rel="stylesheet">
    </noscript>

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/css/contacts-block.css', 'resources/css/base.css', 'resources/css/articles.css', 'resources/js/app.js', 'resources/js/base.js'])
</head>

<body>
    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    {{-- Hero секция с изображением --}}
    <div class="article-hero">
        <div class="article-hero-image">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
            <div class="article-hero-overlay"></div>
        </div>

        <div class="container">
            <div class="article-hero-content">
                {{-- Хлебные крошки --}}
                <nav aria-label="breadcrumb" class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Статьи</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                    </ol>
                </nav>

                <h1 class="article-hero-title">{{ $article->title }}</h1>

                <div class="article-meta">
                    <span class="article-date">
                        <i class="bi bi-calendar3"></i>
                        {{ $article->created_at->format('d.m.Y') }}
                    </span>
                    <span class="article-reading-time">
                        <i class="bi bi-clock"></i>
                        {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} мин. чтения
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Основное содержимое статьи --}}
    <article class="article-single">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    {{-- Excerpt если есть --}}
                    @if ($article->excerpt)
                        <div class="article-excerpt-block">
                            <p class="lead">{{ $article->excerpt }}</p>
                        </div>
                    @endif

                    {{-- Содержимое статьи --}}
                    <div class="article-body">
                        {!! $article->content !!}
                    </div>

                    {{-- Дата обновления --}}
                    @if ($article->updated_at->ne($article->created_at))
                        <div class="article-updated">
                            <small class="text-muted">
                                <i class="bi bi-pencil"></i>
                                Обновлено: {{ $article->updated_at->format('d.m.Y в H:i') }}
                            </small>
                        </div>
                    @endif

                    {{-- Кнопка назад --}}
                    <div class="article-back">
                        <a href="{{ route('articles.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Вернуться к статьям
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </article>

    {{-- Похожие статьи (3 последние, кроме текущей) --}}
    @php
        $relatedArticles = App\Models\Article::where('id', '!=', $article->id)->latest()->take(3)->get();
    @endphp

    @if ($relatedArticles->isNotEmpty())
        <section class="related-articles">
            <div class="container">
                <h2 class="section-title text-center mb-5">Другие статьи</h2>
                <div class="row g-4">
                    @foreach ($relatedArticles as $relatedArticle)
                        <div class="col-lg-4 col-md-6">
                            <div class="article-card">
                                <div class="article-image">
                                    @if ($relatedArticle->image)
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}">
                                            <img src="{{ asset('storage/' . $relatedArticle->image) }}"
                                                alt="{{ $relatedArticle->title }}" loading="lazy">
                                        </a>
                                    @else
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}">
                                            <img src="{{ asset('images/og/og_1763365902_691ad40e216e3.jpg') }}"
                                                alt="{{ $relatedArticle->title }}" loading="lazy">
                                        </a>
                                    @endif
                                </div>
                                <div class="article-content p-4">
                                    <h3 class="article-title">
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}"
                                            class="text-decoration-none">
                                            {{ $relatedArticle->title }}
                                        </a>
                                    </h3>
                                    <p class="article-excerpt text-muted">
                                        {{ $relatedArticle->excerpt ?? Str::limit(strip_tags($relatedArticle->content), 120) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="article-date text-muted">
                                            {{ $relatedArticle->created_at->format('d.m.Y') }}
                                        </small>
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="btn-link">
                                            Читать далее →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('partials.contacts-block')
    @include('partials.footer')

    @stack('scripts')
</body>

</html>
