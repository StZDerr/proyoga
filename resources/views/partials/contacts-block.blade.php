{{-- Блок контактов для переиспользования --}}
<div class="containerMain">
    <div class="container">
        <iframe
            src="https://yandex.ru/map-widget/v1/?um=constructor%3A47c3bf84e9a9b8456b4350ca9f770e0521ba2e58f2e848432f3f9d4aaa4281e6&amp;source=constructor"
            width="500" height="400" frameborder="0"></iframe>
        <div class="content">
            @if (request()->routeIs('contacts'))
                <h1 class="pageTitle">Контакты</h1>
            @else
                <h3 class="pageTitle">Контакты</h3>
            @endif
            <p class="text">
                Исток и Я" - Твой путь к себе начинается с Истока. Здесь соединяются
                тело, дыхание, звук, осознанность и общение.
            </p>
            <div class="adress">село Супсех, ул. Советская, 1Б</div>
            <a href="tel:+78005553535" class="phone">+7 800 555-35-35</a>
            <div class="social">
                <a href="#" class="socialItem" rel="nofollow" target="_blank">
                    <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" />
                </a>
            </div>
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
