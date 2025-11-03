<footer class="site-footer">
    <div class="container">
        <div class="footerWrapper">
            <div class="menu" id="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
                <a href="{{ route('tea') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О студии</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
            </div>

            <div class="footerContent">
                <a href="/" class="logo">
                    <img src="{{ asset('images/logo/logoYOGAwhite.svg') }}" alt="Site Logo" />
                </a>
                <div class="copyright">
                    © Copyright domain.ru - {{ date('Y') }} год
                </div>
                <p class="text">
                    "Исток и Я" - Твой путь к себе начинается с Истока. Здесь
                    соединяются тело, дыхание, звук, осознанность и общение.
                </p>
            </div>

            <div class="footerContent">
                <div class="adress">село Супсех, ул. Советская, 1Б</div>
                <a href="tel:+78005553535" class="phone">+7 (800) 555-35-35</a>
                <a href="{{ route('recording') }}" class="button">Записаться на занятие</a>
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy">
                        <img src="{{ asset('images/svg/yandex_maps.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="https://go.2gis.com/SBzhO" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/reiting2gis_white.svg') }}" alt="2ГИС" />
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
            <a href="https://sumnikoff.ru/" class="info" target="_blank">
                Создание и продвижение сайтов Sumnikoff IT Group
            </a>
        </div>
    </div>
</footer>
