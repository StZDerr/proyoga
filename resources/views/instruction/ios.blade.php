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
                        <svg width="32px" height="32px" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_8317)" />
                            <path
                                d="M18.4468 8.65403C18.7494 8.12586 18.5685 7.45126 18.0428 7.14727C17.5171 6.84328 16.8456 7.02502 16.543 7.55318L16.0153 8.47442L15.4875 7.55318C15.1849 7.02502 14.5134 6.84328 13.9877 7.14727C13.462 7.45126 13.2811 8.12586 13.5837 8.65403L14.748 10.6864L11.0652 17.1149H8.09831C7.49173 17.1149 7 17.6089 7 18.2183C7 18.8277 7.49173 19.3217 8.09831 19.3217H18.4324C18.523 19.0825 18.6184 18.6721 18.5169 18.2949C18.3644 17.7279 17.8 17.1149 16.8542 17.1149H13.5997L18.4468 8.65403Z"
                                fill="white" />
                            <path
                                d="M11.6364 20.5419C11.449 20.3328 11.0292 19.9987 10.661 19.8888C10.0997 19.7211 9.67413 19.8263 9.45942 19.9179L8.64132 21.346C8.33874 21.8741 8.51963 22.5487 9.04535 22.8527C9.57107 23.1567 10.2425 22.975 10.5451 22.4468L11.6364 20.5419Z"
                                fill="white" />
                            <path
                                d="M22.2295 19.3217H23.9017C24.5083 19.3217 25 18.8277 25 18.2183C25 17.6089 24.5083 17.1149 23.9017 17.1149H20.9653L17.6575 11.3411C17.4118 11.5757 16.9407 12.175 16.8695 12.8545C16.778 13.728 16.9152 14.4636 17.3271 15.1839C18.7118 17.6056 20.0987 20.0262 21.4854 22.4468C21.788 22.975 22.4594 23.1567 22.9852 22.8527C23.5109 22.5487 23.6918 21.8741 23.3892 21.346L22.2295 19.3217Z"
                                fill="white" />
                            <defs>
                                <linearGradient id="paint0_linear_87_8317" x1="16" y1="2" x2="16"
                                    y2="30" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#2AC9FA" />
                                    <stop offset="1" stop-color="#1F65EB" />
                                </linearGradient>
                            </defs>
                        </svg>
                        Открыть в App Store
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
            <div class="questions mt-5">
                <div class="container">
                    <div class="d-flex flex-column">
                        <div class="title mb-5">
                            Часто задаваемые вопросы
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse"
                                        aria-expanded="true" aria-controls="collapse">
                                        Забыли пароль?
                                    </button>
                                </h2>
                                <div id="collapse" class="accordion-collapse collapse" aria-labelledby="heading"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Логин для входа — ваш адрес электронной почты. Если вы забыли пароль,
                                        используйте функцию восстановления пароля.
                                        После запроса на восстановление на указанный email придёт письмо с временным
                                        паролем.
                                        <ul class="mb-2 mt-2 text-start">
                                            <li>Перейдите на форму входа и нажмите «Забыли пароль?».</li>
                                            <li>В поле укажите ваш email и отправьте запрос.</li>
                                            <li>Проверьте почту — получите письмо с временным паролем. Используйте email
                                                + этот пароль для входа.</li>
                                            <li>Рекомендуется сразу сменить временный пароль в профиле на собственный,
                                                надёжный.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>
