<footer class="site-footer">
    <div class="container">
        <div class="footerWrapper">
            <div class="menu" id="menu">
                <a href="{{ route('calendar') }}" class="menuItem">Расписание</a>
                <a href="{{ route('price-list') }}" class="menuItem">Цены</a>
                <a href="{{ route('direction') }}" class="menuItem">Направления</a>
                <a href="{{ route('dev') }}" class="menuItem">Чайная зона</a>
                <a href="{{ route('about') }}" class="menuItem">О студии</a>
                <a href="{{ route('contacts') }}" class="menuItem">Контакты</a>
            </div>

            <div class="footerContent">
                <a href="/" class="logo">
                    <img src="{{ asset('images/logo/logoYOGAwhite.svg') }}" alt="Site Logo" loading="lazy"
                        width="200" height="60" />
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
                </a>
                <a href="https://yandex.ru/maps/-/CLvgVLle" target="_blank" class="d-block mt-2">
                    <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
                </a>
                <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
                <a href="{{ route('recording') }}" class="button">Получить констультацию</a>
                <div class="rating">
                    <a href="https://yandex.ru/maps/-/CLfTYTjy" rel="nofollow" target="_blank">
                        <img src="{{ asset('images/svg/yandexNewWhite.svg') }}" alt="Яндекс" />
                    </a>
                    <a href="https://go.2gis.com/SBzhO" rel="nofollow" target="_blank">
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
            <a href="https://sumnikoff.ru/" class="info" target="_blank">
                Создание и продвижение сайтов Sumnikoff IT Group
            </a>
        </div>
    </div>
</footer>
