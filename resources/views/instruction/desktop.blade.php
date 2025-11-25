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
                        <svg class="store-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96 2.694-1.586Zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055l7.294-4.295ZM1 13.396V2.603L6.846 8 1 13.396ZM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27Z" />
                        </svg>
                        Google Play
                    </a>
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://apps.apple.com/ru/app/%D0%B8%D1%81%D1%82%D0%BE%D0%BA%D0%B8%D1%8F/id6755461126"
                        target="_blank" rel="noopener">
                        <svg class="store-icon"viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        App Store
                    </a>
                    <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                        href="https://www.rustore.ru/catalog/app/com.appeventru.fitapp_18869" target="_blank"
                        rel="noopener">
                        <svg class="store-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_296_2063)">
                                <path
                                    d="M1.92878 22.0712C3.5763 23.7188 6.22795 23.7188 11.5312 23.7188H12.4688C17.772 23.7188 20.4237 23.7188 22.0712 22.0712C23.7188 20.4237 23.7188 17.772 23.7188 12.4687V11.5312C23.7188 6.22786 23.7188 3.5762 22.0712 1.92868C20.4237 0.281249 17.772 0.28125 12.4688 0.28125H11.5312C6.22795 0.28125 3.5763 0.281251 1.92878 1.92868C0.28125 3.5762 0.28125 6.22786 0.28125 11.5312V12.4687C0.28125 17.772 0.281251 20.4237 1.92878 22.0712Z"
                                    fill="#0077FF"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M18.3762 15.8596L16.7927 15.4641C16.602 15.4094 16.4673 15.2378 16.4605 15.0384L16.2629 9.20977C16.2057 8.43831 15.6331 7.82476 15.0346 7.64406C15.0011 7.63393 14.9652 7.64757 14.9453 7.67649C14.925 7.70584 14.9329 7.74652 14.9611 7.76837C15.1088 7.88274 15.5156 8.25606 15.5156 8.89998L15.5144 16.5207C15.5144 17.2565 14.819 17.7962 14.1018 17.617L12.4938 17.2153C12.3155 17.1529 12.1916 16.9869 12.1851 16.7954L11.9875 10.9664C11.9303 10.1949 11.3577 9.58135 10.7592 9.40065C10.7256 9.39052 10.6897 9.40416 10.6699 9.43309C10.6497 9.46248 10.6574 9.50312 10.6857 9.52496C10.8334 9.63934 11.2401 10.0126 11.2401 10.6566L11.239 17.0088L11.2399 17.009V18.278C11.2399 19.0139 10.5445 19.5535 9.82728 19.3744L5.28519 18.2397C4.6537 18.082 4.21094 17.5171 4.21094 16.8693L4.21094 9.23668C4.21094 8.50084 4.9063 7.96112 5.62353 8.14032L8.48548 8.85521V7.47934C8.48548 6.74349 9.18083 6.20377 9.89806 6.38293L12.7599 7.09787V5.72195C12.7599 4.98606 13.4553 4.44638 14.1725 4.62555L18.7146 5.7602C19.346 5.91793 19.7888 6.48282 19.7888 7.13068V14.7632C19.7888 15.4991 19.0935 16.0388 18.3762 15.8596Z"
                                    fill="white"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_296_2063">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg> RuStore
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
