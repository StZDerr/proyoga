<header class="site-header">
    <div class="container">
        <div class="containerWrapper">
            <div class="wrapper">
                <div class="rating">
                    <a href="#" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandex_maps_5_1.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="#" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/reiting2gis.svg') }}" alt="2ГИС" />
                    </a>
                </div>
                <div class="adress">село Супсех, ул. Советская, 1Б</div>
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
                <a href="tel:+78005553535" class="phone">+7 (800) 555-35-35</a>
                @auth
                    <a href="{{ route('admin') }}" class="button"
                        style="background-color: #6c757d; margin-right: 10px;">Админка</a>
                @endauth
                {{-- <a href="#" class="button" id="bid">Записаться на занятие</a> --}}
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
        <a href="tel:+78005553535" class="phone">+7 (800) 555-35-35</a>
        <div class="menuMobile">
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="menu" id="menu">
                <a href="#" class="menuItem">Расписание</a>
                <a href="#" class="menuItem">Цены</a>
                <a href="#" class="menuItem">Направления</a>
                <a href="#" class="menuItem">Чайная зона</a>
                <a href="#" class="menuItem">О студии</a>
                <a href="#" class="menuItem">Контакты</a>
                <a href="tel:+78005553535" class="menuItem phone">
                    +7 800 555-35-35
                </a>
                <div class="adress">село Супсех, ул. Советская, 1Б</div>
                <a href="#" class="button" id="bid">Записаться на занятие</a>
                <div class="rating">
                    <a href="#" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandex_maps_5_1.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="#" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/reiting2gis.svg') }}" alt="2ГИС" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
