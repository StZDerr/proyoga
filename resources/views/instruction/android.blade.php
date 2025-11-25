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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-google-play" viewBox="0 0 16 16">
                                <path
                                    d="M14.222 9.374c1.037-.61 1.037-2.137 0-2.748L11.528 5.04 8.32 8l3.207 2.96 2.694-1.586Zm-3.595 2.116L7.583 8.68 1.03 14.73c.201 1.029 1.36 1.61 2.303 1.055l7.294-4.295ZM1 13.396V2.603L6.846 8 1 13.396ZM1.03 1.27l6.553 6.05 3.044-2.81L3.333.215C2.39-.341 1.231.24 1.03 1.27Z" />
                            </svg>
                            Google Play
                        </a>
                        <a class="btn btn-lg btn-outline-dark mx-2 my-1"
                            href="https://www.rustore.ru/catalog/app/com.appeventru.fitapp_18869" target="_blank"
                            rel="noopener">
                            <svg class="store-icon" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
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
