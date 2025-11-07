<header class="site-header">
    <div class="container">
        <div class="containerWrapper">
            <div class="wrapper">
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandexNew.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="https://go.2gis.com/SBzhO" rel="nofollow" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/2gisNew.svg') }}" alt="2ГИС" />
                    </a>
                </div>
                <div class="adres ">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" target="_blank">
                        <div class="adress">с. Супсех, ул. Советская, 1Б</div>
                    </a>
                    <a href="https://yandex.ru/maps/-/CLvgVLle" target="_blank" class="d-block mt-4">
                        <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
                    </a>
                </div>
            </div>
            <div class="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
            </div>
        </div>
        <a href="/" class="logo">
            <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Site Logo" />
        </a>
        <div class="containerWrapper">
            <div class="clear"></div>
            <div class="wrapper">
                <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
                {{-- @auth
                    <a href="{{ route('admin') }}" class="button"
                        style="background-color: #6c757d; margin-right: 10px;">Админка</a>
                @endauth --}}
                <a href="{{ route('recording') }}" class="button">Записаться на занятие</a>
            </div>
            <div class="menu">
                <a href="{{ route('tea') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О студии</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
            </div>
        </div>
    </div>
    <div class="containerMobile">
        <a href="/" class="logo">
            <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Site Logo" />
        </a>
        <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
        <div class="menuMobile">
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="menu" id="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
                <a href="{{ route('tea') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О студии</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
                <a href="tel:+79649264147" class="menuItem phone">
                    +7 (964) 926-41-47
                </a>
                <a href="https://yandex.ru/maps/-/CLfTYTjy">
                    <div class="adress">с. Супсех, ул. Советская, 1Б</div>
                </a>
                <a href="https://yandex.ru/maps/-/CLvgVLle" target="_blank" class="d-block mt-2">
                    <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
                </a>
                <a href="{{ route('recording') }}" class="button">Записаться на занятие</a>
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandexNew.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="https://go.2gis.com/SBzhO" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/2gisNew.svg') }}" alt="2ГИС" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
