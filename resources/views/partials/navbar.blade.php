<script src="https://unpkg.com/headroom.js@0.12.0/dist/headroom.min.js"></script>
<header class="site-header">
    <div class="container">
        <!-- Верхний блок с рейтингом и адресами -->
        <div class="containerWrapper">
            <div class="wrapper hideable-content">
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" target="_blank">
                        <img src="{{ asset('images/svg/yandexNew.svg') }}" alt="Яндекс" width="141" height="34" />
                    </a>
                    <a href="https://go.2gis.com/Bn289" target="_blank">
                        <img src="{{ asset('images/svg/2gisNew.svg') }}" alt="2ГИС" width="141" height="34" />
                    </a>
                </div>
                <div class="adres">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" target="_blank">
                        <div class="adress">с. Супсех, ул. Советская, 1Б</div>
                        <span class="adress-desc">Залы групповых занятий, чайная зона, массаж</span>
                    </a>
                    <a href="https://yandex.ru/maps/-/CLvgVLle" target="_blank" class="d-block">
                        <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
                        <span class="adress-desc">Индивидуальные тренировки, массаж, психолог</span>
                    </a>
                </div>
            </div>

            <!-- Навигация верхнего блока -->
            <div class="menu">
                <a href="{{ route('welcome') }}" class="menuItem">Главная</a>
                <a href="{{ route('about') }}" class="menuItem">О Центре</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
            </div>
        </div>

        <!-- Логотип -->
        <a href="/" class="logo">
            <img src="{{ $setting->navbar_logo_url ?? asset('images/logo/ngist.svg') }}" alt="Site Logo" />
        </a>

        <!-- Нижний блок с контактами и кнопкой -->
        <div class="containerWrapper">
            <div class="clear hideable-content"></div>
            <div class="wrapper hideable-content">
                <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
                <a href="{{ route('recording') }}" class="button">Получить консультацию</a>
            </div>

            <div class="menu">
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                {{-- <a href="{{ route('dev') }}" class="menuItem">Чайная зона</a> --}}
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('photo-galleries') }}" class="menuItem">Фото</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
            </div>
        </div>
    </div>

    <div class="containerMobile">
        <a href="/" class="logo">
            <img src="{{ $setting->navbar_logo_url ?? asset('images/logo/ngist.svg') }}" alt="Site Logo" width="144"
                height="120" loading="lazy">
        </a>
        <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
        <div class="menuMobile">
            <div class="menu-toggle" id="menuToggle"><span></span><span></span><span></span></div>
            <div class="menu" id="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
                <a href="{{ route('dev') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О студии</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
                <a href="{{ route('photo-galleries') }}" class="menuItem">Фотогалерея</a>
                <a href="tel:+79649264147" class="menuItem phone">+7 (964) 926-41-47</a>
                <a href="{{ route('recording') }}" class="button">Получить консультацию</a>
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" target="_blank">
                        <img src="{{ asset('images/svg/yandexNew.svg') }}" alt="Яндекс" width="141"
                            height="34" />
                    </a>
                    <a href="https://go.2gis.com/SBzhO" target="_blank">
                        <img src="{{ asset('images/svg/2gisNew.svg') }}" alt="2ГИС" width="141"
                            height="34" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
