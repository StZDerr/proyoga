<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans:wght@400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/modal-test.css', 'resources/js/yoga-test.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h2>Тестирование модального окна</h2>
                        <p>Нажмите кнопку ниже, чтобы открыть тест на определение уровня гибкости</p>
                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#testModal">
                            Пройти тест гибкости
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Модальное окно теста --}}
    @include('partials.modal-test')

    {{-- Скрипт теста загружается после Bootstrap --}}
    @vite(['resources/js/yoga-test.js'])
</body>

</html>
