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

    <div class="background-gor mb-5">
        {{-- Основной блок контактов --}}
        <div class="headerTeaZone mt-5">
            <div class="container text-center">
                <div class="zaglyshka mt-5">
                    <div class="container">
                        <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Icon" class="img-fluid"
                            style="width: 300px; max-width: 100%; height: auto;" />
                        <div class="title">Данный раздел находится в разработке</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>
