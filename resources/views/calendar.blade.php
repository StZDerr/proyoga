<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/about.css', 'resources/js/about.js', 'resources/js/recording-form.js', 'resources/css/contacts-block.css', 'resources/css/recording.css'])
</head>

<body>

    @include('partials.navbar')
    <div class="container">
        <iframe class="aeCustomWidget"
            src="//appevent.ru/widget/embeded?widget_key=8d72037d71fe2300577cb286d7d4fae7&hall_id=24709" width="100%"
            height="1120px" style="background: #ffffff;border: none;"></iframe>
    </div>
    @include('partials.recording-block')
    @include('partials.contacts-block')
    @include('partials.footer')

</body>

</html>
