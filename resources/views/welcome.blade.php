<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПроЙога</title>

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/welcome.css', 'resources/css/navbar.css', 'resources/css/footer.css'])
</head>

<body class="antialiased bg-light">

    @include('partials.navbar')

    <main class="container text-center py-5">
        <h1 class="display-4 mb-3">Добро пожаловать в студию ПроЙога</h1>
        <p class="lead mb-4">Гармония тела и разума начинается здесь.</p>
        <a href="#" class="btn btn-success btn-lg">Записаться на занятие</a>
    </main>

    @include('partials.footer')

</body>

</html>
