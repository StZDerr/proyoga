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

    <div class="background-gor mb-4">
        <div class="container text-center pt-5">
            <div class="contacts-header">
                <h1 class="display-4 mb-3 title-text">Инструкция по установке приложения</h1>

                <div class="d-flex justify-content-center mb-4 flex-wrap">
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://play.google.com/store/apps/details?id=com.appeventru.fitapp_18869&pli=1"
                        target="_blank" rel="noopener">
                        ▶️ Google Play
                    </a>
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://apps.apple.com/ru/app/%D0%B8%D1%81%D1%82%D0%BE%D0%BA%D0%B8%D1%8F/id6755461126"
                        target="_blank" rel="noopener">
                        🍎 App Store
                    </a>
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://www.rustore.ru/catalog/app/com.appeventru.fitapp_18869" target="_blank"
                        rel="noopener">
                        🛍️ RuStore
                    </a>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-5 text-start mb-4">
                        <h3>Для Android (Google Play / RuStore)</h3>
                        <ol>
                            <li>Откройте магазин по кнопке «Google Play» или «RuStore» выше.</li>
                            <li>Нажмите «Установить» (или «Получить» для RuStore) и дождитесь загрузки.</li>
                            <li>Откройте приложение из меню телефона или нажмите «Открыть» в магазине.</li>
                            <li>Если устройство блокирует установку, разрешите установку из этого источника в настройках
                                безопасности (для RuStore/сторонних APK).</li>
                        </ol>
                    </div>

                    <div class="col-md-5 text-start mb-4">
                        <h3>Для iOS (App Store)</h3>
                        <ol>
                            <li>Перейдите в App Store по кнопке «App Store» выше.</li>
                            <li>Нажмите кнопку скачивания (облако/полоса) или «Получить» и авторизуйтесь с Apple ID при
                                необходимости.</li>
                            <li>Дождитесь установки и откройте приложение с домашнего экрана.</li>
                            <li>Если возникают проблемы — проверьте ограничение установки приложений в «Экранное время»
                                или обновите iOS до последней версии.</li>
                        </ol>
                    </div>
                </div>

                <div class="mt-3 text-start">
                    <h4>Полезные советы</h4>
                    <ul>
                        <li>Если ссылка не открывается на телефоне, скопируйте её и откройте вручную в браузере
                            устройства.</li>
                        <li>Проверяйте, что на устройстве достаточно места и стабильное соединение (Wi‑Fi или мобильный
                            интернет).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>
