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

    <div class="instruction">
        <div class="background-gor mb-4">
            <div class="container text-center pt-5">
                <div class="contacts-header">
                    <h1 class="display-4 mb-3 title-text">Установка приложения на Android</h1>

                    <div class="d-flex justify-content-center mb-4 flex-wrap">
                        <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                            href="https://play.google.com/store/apps/details?id=com.appeventru.fitapp_18869&pli=1"
                            target="_blank" rel="noopener">
                            ▶️ Google Play
                        </a>
                        <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                            href="https://www.rustore.ru/catalog/app/com.appeventru.fitapp_18869" target="_blank"
                            rel="noopener">
                            🛍️ RuStore
                        </a>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 text-start mb-4">
                            <h3>Установка из Google Play</h3>
                            <ol>
                                <li>Откройте Google Play по кнопке «Google Play» выше.</li>
                                <li>Нажмите «Установить» и дождитесь завершения загрузки.</li>
                                <li>Откройте приложение из меню телефона или нажмите «Открыть» в магазине.</li>
                            </ol>
                        </div>

                        <div class="col-md-5 text-start mb-4">
                            <h3>Установка через RuStore / сторонний APK</h3>
                            <ol>
                                <li>Откройте RuStore по кнопке «RuStore» выше.</li>
                                <li>Нажмите «Получить» / «Установить» и следуйте подсказкам магазина.</li>
                                <li>Если устанавливаете APK вручную: в настройках безопасности разрешите установку из
                                    этого
                                    источника.</li>
                                <li>После установки откройте приложение с домашнего экрана.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="mt-3 text-start">
                        <h4>Полезные советы</h4>
                        <ul>
                            <li>Если ссылка не открывается на телефоне — скопируйте её в мобильный браузер.</li>
                            <li>Проверьте свободное место и стабильное соединение (Wi‑Fi предпочтительнее).</li>
                            <li>При проблемах с установкой для RuStore/APK — временно разрешите установку из неизвестных
                                источников в настройках безопасности.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>
