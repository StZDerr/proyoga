<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/recording.css', 'resources/js/recording-form.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    <div class="background-gor mb-5">
        {{-- Основной блок контактов --}}
        <div class="headerTeaZone mt-5">
            <div class="container text-center">
                <div class="text-center mt-4">
                    <div id="thanks-animation" style="width:320px;height:320px;margin:0 auto;"></div>
                </div>
                <div class="title">
                    Спасибо за вашу заявку!
                </div>
                <div class="desc">
                    Мы свяжемся с вами в ближайшее время.
                </div>
                <!-- Lottie animation container -->

            </div>
        </div>
    </div>

    @include('partials.footer')

    {{-- Lottie player (loads animation JSON from public/images) --}}
    <script src="https://unpkg.com/lottie-web@5.9.6/build/player/lottie.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var container = document.getElementById('thanks-animation');
                if (!container) return;

                lottie.loadAnimation({
                    container: container,
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('images/animation-1737537656517-6.json') }}"
                });
            } catch (e) {
                // Fail silently in production
                console.error('Lottie load error:', e);
            }
        });
    </script>

</body>

</html>
