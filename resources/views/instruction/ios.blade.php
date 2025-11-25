<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/instruction.css', 'resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/js/lazy-iframe.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    <div class="background-gor mb-3">
        <div class="container text-center pt-5">
            <div class="contacts-header">
                <h1 class="display-4 mb-3 title-text">Установка приложения на iPhone</h1>

                <div class="d-flex justify-content-center mb-4">
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://apps.apple.com/ru/app/%D0%B8%D1%81%D1%82%D0%BE%D0%BA%D0%B8%D1%8F/id6755461126"
                        target="_blank" rel="noopener">
                        🍎 Открыть в App Store
                    </a>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="col-md-8 text-start mb-4">
                        <h3>Пошаговая инструкция для iOS</h3>
                        <ol>
                            <li>Откройте ссылку в App Store, нажав кнопку выше.</li>
                            <li>Нажмите кнопку загрузки (облако/строка или «Получить»). При необходимости подтвердите с
                                Apple ID.</li>
                            <li>Дождитесь завершения загрузки и установки — иконка появится на домашнем экране.</li>
                            <li>Если установка не начинается — проверьте настройки «Экранное время» → «Контент и
                                конфиденциальность» и убедитесь, что ограничения на установку приложений отключены.</li>
                        </ol>
                    </div>
                </div>

                <div class="mt-3 text-start">
                    <h4>Полезные советы</h4>
                    <ul>
                        <li>Если ссылка не открывается на телефоне, скопируйте её в мобильный браузер вручную.</li>
                        <li>Убедитесь, что на устройстве достаточно свободного места и стабильный интернет (лучше
                            Wi‑Fi).</li>
                        <li>Если требуется — обновите iOS до последней доступной версии.</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a class="btn btn-primary btn-lg mx-1"
                        href="https://apps.apple.com/ru/app/%D0%B8%D1%81%D1%82%D0%BE%D0%BA%D0%B8%D1%8F/id6755461126"
                        target="_blank" rel="noopener">Установить на iPhone</a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>
