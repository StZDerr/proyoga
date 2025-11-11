<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/js/photoGalleries.js', 'resources/css/photoGalleries.css', 'resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    <div class="photo-galleries">
        <div class="container">
            @foreach ($photos as $photo)
                <a href="{{ asset('storage/' . $photo->image) }}" class="gallery3-item">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}" loading="lazy"
                        width="800" height="600">
                </a>
            @endforeach
        </div>
    </div>


    @include('partials.footer')
</body>

</html>
