<footer class="site-footer">
    <div class="container">
        <div class="footerWrapper">
            <div class="menu" id="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
                <a href="{{ route('dev') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О Центре</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
                <a href="{{ route('photo-galleries') }}" class="menuItem">Фотогалерея</a>
            </div>

            <div class="footerContent">
                <a href="/" class="logo">
                    <img src="{{ $setting->footer_logo_url ?? asset('images/logo/ngist.svg') }}" alt="Site Logo"
                        loading="lazy" width="200" height="60" />
                </a>
                <div class="copyright">
                    © Copyright истокия.рф - {{ date('Y') }} год
                </div>
                <p class="text">
                    "ИстокиЯ" - Твой путь к себе начинается с Истока. Здесь
                    соединяются тело, дыхание, звук, осознанность и общение.
                </p>
            </div>

            <div class="footerContent">
                <a href="https://yandex.ru/maps/-/CLfTYTjy">
                    <div class="adress">с. Супсех, ул. Советская, 1Б</div>
                    <span class="adress-desc">Залы групповых занятий, чайная зона, массаж</span>
                </a>
                <a href="https://yandex.ru/maps/-/CLvgVLle" target="_blank" class="d-block mt-2">
                    <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
                    <span class="adress-desc">Индивидуальные тренировки, массаж, психолог</span>
                </a>
                <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
                <a href="{{ route('recording') }}" class="button">Получить констультацию</a>
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandexNewWhite.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="https://go.2gis.com/Bn289" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/2gisNewWhite.svg') }}" alt="2ГИС" />
                    </a>
                </div>
            </div>
        </div>
        <hr />
        <div class="legalInfo">
            <a href="/privacy-policy" class="info">
                Политика конфиденциальности
            </a>
            <a href="/personal-data" class="info">
                Согласие на обработку персональных данных
            </a>
            <a href="/oferta" class="info">
                Публичная оферта
            </a>
            <a href="https://sumnikoff.ru/" class="info" target="_blank">
                Создание и продвижение сайтов Sumnikoff IT Group
            </a>
        </div>
    </div>
    <div class="fixedSocial">
        <a href="{{ route('calendar') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-calendar-week" viewBox="0 0 16 16">
                <path
                    d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
            </svg>
        </a>
        <a href="tel:+79649264147">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-telephone-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
            </svg>
        </a>
        <a href="{{ route('instruction') }}">
            @php
                $ua = strtolower(request()->header('User-Agent') ?? '');
                if (strpos($ua, 'android') !== false) {
                    $svgPath = public_path('images/logo/android_h934ogykvqsj 1.svg');
                } elseif (
                    strpos($ua, 'iphone') !== false ||
                    strpos($ua, 'ipad') !== false ||
                    strpos($ua, 'ipod') !== false
                ) {
                    $svgPath = public_path('images/logo/logotip_apple_4ihwb0rzknhx 1.svg');
                } else {
                    $svgPath = public_path('images/logo/windows_66vizbaznjal 1.svg');
                }
            @endphp

            @if (file_exists($svgPath))
                {!! file_get_contents($svgPath) !!}
            @else
                <img src="{{ asset('images/logo/windows_66vizbaznjal 1.svg') }}" alt="logo" loading="lazy"
                    width="16" height="16" />
            @endif
        </a>
    </div>
</footer>
