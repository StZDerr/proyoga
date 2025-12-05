<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/css/articles.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/js/lazy-iframe.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    @if ($articles->isNotEmpty())
        <div class="articles-section mt-5 py-5">
            <div class="container">
                <div class="title mb-5 text-center">
                    Полезные статьи
                </div>
                <div class="row g-4">
                    @foreach ($articles as $article)
                        <div class="col-lg-4 col-md-6">
                            <div class="article-card h-100">
                                @if ($article->image)
                                    <div class="article-image">
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                            class="img-fluid">
                                    </div>
                                @endif
                                <div class="article-content p-4">
                                    <h3 class="article-title">{{ $article->title }}</h3>
                                    <p class="article-excerpt text-muted">
                                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="article-date text-muted small">
                                            {{ $article->created_at->format('d.m.Y') }}
                                        </span>
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="btn btn-link text-decoration-none">
                                            Читать далее
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $articles->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('partials.footer')

</body>

</html>
