{{-- Блок контактов для переиспользования --}}
<div class="containerMain mb-5 mt-5">
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
                "ИстокиЯ" - Твой путь к себе начинается с Истока. Здесь соединяются
                тело, дыхание, звук, осознанность и общение.
            </p>
            <div class="adress">с. Супсех, ул. Советская, 1Б</div>
            <div class="adress">г. Анапа, ул. 40 лет Победы, 1Б, оф. 115</div>
            <a href="tel:+79649264147" class="phone">+7 (964) 926-41-47</a>
            <div class="social">
                <a href="https://vk.com/myistokiya" class="socialItem" rel="nofollow" target="_blank">
                    <img src="{{ asset('images/svg/vk.svg') }}" alt="VKontakte" />
                </a>
            </div>
            <div class="rating">
                <a href="https://yandex.ru/maps/-/CLfTYTjy" rel="nofollow" target="_blank">
                    <img src="{{ asset('images/svg/yandexNew.svg') }}" alt="Яндекс" />
                </a>
                <a href="https://go.2gis.com/SBzhO" rel="nofollow" target="_blank">
                    <img src="{{ asset('images/svg/2gisNew.svg') }}" alt="2ГИС" />
                </a>
            </div>

            {{-- Форма обратной связи (только на странице контактов)
            @if (request()->routeIs('contacts'))
                <div class="contact-form-section mt-4">
                    <h4 class="mb-3">Напишите нам</h4>
                    <form id="contactForm" class="contact-form">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Ваше имя" required
                                minlength="2" maxlength="50" pattern="[а-яёА-ЯЁa-zA-Z\s\-]+">
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" name="phone" placeholder="Телефон" required
                                pattern="[0-9\s\(\)\-\+]*" minlength="10">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email"
                                placeholder="Email (необязательно)">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="4" placeholder="Ваше сообщение" maxlength="1000"></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="contactPrivacy" name="privacy_agreement"
                                required>
                            <label class="form-check-label" for="contactPrivacy">
                                Я согласен(-на) с политикой конфиденциальности
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                    </form>
                </div>
            @endif
        </div> --}}
        </div>
    </div>
</div>
