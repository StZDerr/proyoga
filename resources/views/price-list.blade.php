<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        // Вставляем пустую строку, если ключ не задан, чтобы не ломать инициализацию
        window.LG_LICENSE_KEY = "{{ config('services.lightgallery.key') ?? '' }}";
    </script>
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/price-list.css', 'resources/js/price-list.js', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="background-gor-price-list">
        <div class="container ">
            {{ Breadcrumbs::render('price-list') }}
            <div class="title mt-5">
                Прайс-лист
            </div>
            <div class="desc">
                Занимайтесь один раз в неделю или каждый день, выбирайте подходящий абонемент и записывайтесь на
                занятия.
            </div>
        </div>
    </div>

    <div class="price-list">
        <div class="container">
            <!-- Кнопки категорий -->
            <div class="d-flex flex-wrap justify-content-center btn-container mt-5" id="categoryButtons">
                @foreach ($categories as $index => $category)
                    <button class="category-btn {{ $index === 0 ? 'active' : 'inactive' }}"
                        data-target="content-{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Контент категорий -->
            @foreach ($categories as $index => $category)
                <div id="content-{{ $category->slug }}" class="content-text {{ $index === 0 ? 'active' : '' }}">
                    @if ($category->file)
                        @if (Str::endsWith($category->file, '.pdf'))
                            <iframe src="{{ asset('storage/' . $category->file) }}" width="100%" height="800"
                                style="border: none;"></iframe>
                        @else
                            <div class="d-flex justify-content-center">
                                <a href="{{ asset('storage/' . $category->file) }}" class="lightbox">
                                    <img src="{{ asset('storage/' . $category->file) }}" alt="{{ $category->name }}"
                                        class="img-fluid rounded shadow price-image">
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted mt-4">Файл для этой категории ещё не загружен.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-5">
        @include('partials.recording-block')
    </div>
    @include('partials.footer')

</body>

</html>
