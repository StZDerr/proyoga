<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/contacts.css', 'resources/css/contacts-block.css'])
</head>

<body>

    @include('partials.navbar')

    <div class="background-gor">
        <div class="container text-center py-5">
            <div class="contacts-header">
                <h1 class="display-4 mb-3 title-text">Контакты</h1>
                <p class="lead mb-4">Свяжитесь с нами удобным для вас способом</p>
            </div>
        </div>

        {{-- Основной блок контактов --}}
        @include('partials.contacts-block')
    </div>

    @include('partials.footer')

</body>

</html>
