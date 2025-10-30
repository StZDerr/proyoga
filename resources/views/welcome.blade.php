<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПроЙога</title>
    @include('partials.favicon')

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans:wght@400&display=swap" rel="stylesheet">

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/welcome.css', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/contacts-block.css', 'resources/js/welcome_new.js', 'resources/js/navbar.js', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/modal-test.css', 'resources/js/yoga-test.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    @include('partials.navbar')
    <div class="background-gor">
        <div class="container text-center py-5">
            <div class="main">
                <h1 class="display-4 mb-3 title-text">Центр физического и ментального здоровья</h1>
                <p class="lead mb-4">ИстокиЯ</p>

                {{-- Swiper слайдер --}}
                <div class="swiper my-custom-swiper-container mt-5">
                    <div class="swiper-wrapper">
                        @foreach ($promotions as $promotion)
                            <div class="swiper-slide">
                                <div class="card shadow-sm">
                                    <img src="{{ asset('storage/' . $promotion->photo) }}"
                                        alt="{{ $promotion->title }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-info-text">
                    Твой путь к себе начинается с Истока
                </div>
                <div class="container-button d-flex justify-content-center gap-4 mt-4">
                    <a href="">
                        <button type="button" class="btn btn-primary button-bid">Записаться на занятие</button>
                    </a>
                    <a href="">
                        <button type="button" class="btn btn-light button-calendar">Расписание занятий</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="marquee-wrapper">
            <!-- Первая лента -->
            <div class="marquee marquee-light">
                <div class="marquee-content">
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Функциональные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Динамические медитации</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Эксклюзивные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Мастер-классы</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Растяжка</span>
                    </div>

                    <!-- Повторяем элементы для бесконечного эффекта -->
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Функциональные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Динамические медитации</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Эксклюзивные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Мастер-классы</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Растяжка</span>
                    </div>
                </div>
            </div>

            <!-- Вторая лента -->
            <div class="marquee marquee-dark">
                <div class="marquee-content">
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Функциональные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Динамические медитации</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Эксклюзивные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Мастер-классы</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Растяжка</span>
                    </div>

                    <!-- Повторяем элементы для бесконечного эффекта -->
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Функциональные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Динамические медитации</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Эксклюзивные тренировки</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Мастер-классы</span>
                    </div>
                    <div class="marquee-item">
                        <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" />
                        <span>Растяжка</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="istoria"></div>
    </div>
    <div class="about py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 about-img mb-4 mb-lg-0 text-center text-lg-start">
                    <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Icon" class="img-fluid" />
                </div>
                <div class="col-lg-6 col-12 about-text">
                    <div class="title">
                        "Исток и Я" — Твой путь к себе начинается с Истока.
                        Здесь соединяются тело, дыхание, звук, осознанность и общение.
                    </div>
                    <div class="desc mt-3">
                        В “Исток и Я” проходят занятия по йоге, пилатесу, дыхательным и телесным практикам,
                        арт-терапии и медитациям, а также регулярные ретриты, женские и мужские круги,
                        трансформационные программы и выездные сессии на природе.
                        Два зала, чайная зона и собственный автобус для путешествий — всё продумано,
                        чтобы вы могли возвращаться к своему Истоку.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="directions">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text">
                    <h2 class="section-title">Направления занятий</h2>
                    <span>Мы поможем подобрать направление йоги, которое подходит именно Вам</span>
                </div>
                <div class="button">
                    <a href="{{ route('direction') }}" class="text-decoration-none text-dark">
                        Все направления
                    </a>
                </div>
            </div>
            <div class="row g-4 main-directions mt-2">
                @foreach ($mainCategories as $mainCategory)
                    @foreach ($mainCategory->subCategories as $subCategory)
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <a href="{{ route('PodDirection', $subCategory->id) }}"
                                class="text-decoration-none text-dark">
                                <div class="card-directions">
                                    @if ($subCategory->image)
                                        <img src="{{ asset('storage/' . $subCategory->image) }}"
                                            alt="{{ $subCategory->title }}" />
                                    @else
                                        <img src="{{ asset('images/directions-background.webp') }}"
                                            alt="directions-background" />
                                    @endif
                                    <div class="d-flex justify-content-between p-3">
                                        <div class="title">
                                            {{ $subCategory->title }}
                                        </div>
                                        <div class="arrow">
                                            <i class="bi bi-arrow-right fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="text">
                                        {{ $subCategory->description ?? 'Описание направления' }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <div class="price-list">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text">
                    <h2 class="section-title">Прайс-лист</h2>
                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem qui sed recusandae quod
                        natus expedita quo facilis, officia dolor distinctio.</span>
                </div>
                <a href="" class="btn button">
                    Записаться на занятия
                </a>
            </div>
            <div class="d-flex flex-wrap justify-content-center btn-container mt-5" id="categoryButtons">
                @foreach ($categories as $index => $category)
                    <button class="category-btn {{ $index === 0 ? 'active' : 'inactive' }}"
                        data-target="content-{{ $category->slug }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- ТЕКСТЫ — ВСЁ В HTML -->
            @foreach ($categories as $index => $category)
                <div id="content-{{ $category->slug }}" class="content-text {{ $index === 0 ? 'active' : '' }}">
                    @foreach ($category->tables as $table)
                        <table class="custom-table">
                            <tr class="table-title-row">
                                <td colspan="2" class="table-title">{{ $table->title }}</td>
                            </tr>
                            @foreach ($table->items as $item)
                                <tr class="table-item-row">
                                    <td class="table-item-name">{{ $item->name }}</td>
                                    <td class="table-item-info">
                                        <div class="table-item-duration">{{ $item->duration }}</div>
                                        <div class="table-item-price">{{ $item->price }} ₽</div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <div class="about-space">
        <div class="container">
            <div class="title">
                Наше пространство создано для всех, кто ценит комфорт, уют и заботу <span> не только о своём
                    теле, но и душе.</span>
            </div>
            <div class="text">
                Внутри студии создана атмосфера уюта и спокойствия, что помогает сосредоточиться на занятиях. Светлые
                тона и приятные ароматы создают замечательное настроение.
                Вы найдете все необходимое для эффективной тренировки и расслабления после неё.
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/people.svg') }}" alt="people" />
                        </div>
                        <div class="about-space-features-text">
                            Разные направления физического и духовного развития
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="people" />
                        </div>
                        <div class="about-space-features-text">
                            Разные направления физического и духовного развития
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/comp.svg') }}" alt="people" />
                        </div>
                        <div class="about-space-features-text">
                            Разные направления физического и духовного развития
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="calendar mt-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text">
                    <h2 class="section-title">Расписание занятий</h2>
                    <span>Выберите удобное для вас время занятий</span>
                </div>
                <a href="" class="btn button">
                    Смотреть полностью
                </a>
            </div>
        </div>
    </div>
    <div class="retreats mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-7">
                    <div class="title">
                        Выездные сессии “Исток и Я - путешествия к себе”
                    </div>
                    <div class="desc">
                        В “Исток и я” проходят занятия по йоге, пилатесу, дыхательным и телесным практикам, арт-терапии
                        и медитациям, а также регулярные ретриты, женские и мужские круги, трансформационные программы и
                        выездные сессии на природе.
                        Два зала, чайная зона и собственный автобус для путешествий - всё продумано, чтобы вы могли
                        возвращаться к своему Истоку.
                        Два зала, чайная зона и собственный автобус для путешествий - всё продумано, чтобы вы могли
                        возвращаться к своему Истоку.
                    </div>
                    <a href="" class="btn btn-more mt-4">
                        Подробнее <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12 col-xl-5 text-end mt-5">
                    <img src="{{ asset('images/Off-siteSessions.webp') }}" alt="Off-siteSessions">
                </div>
            </div>
        </div>
    </div>
    <div class="teachers mt-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text">
                    <h2 class="section-title">Наши преподаватели</h2>
                    <span>Доверьтесь команде профессионалов</span>
                </div>
                {{-- <a href="" class="btn button">
                    Смотреть полностью
                </a> --}}
            </div>
            {{-- Свайпер для преподавателей --}}
            <div class="teachers-swiper-container mt-4 position-relative">
                <!-- Стрелки навигации -->
                <div class="swiper-button-prev teachers-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-next teachers-next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>

                <div class="swiper teachers-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($personals as $personal)
                            <div class="swiper-slide">
                                <div class="teacher-card">
                                    <img src="{{ asset('storage/' . $personal->photo) }}"
                                        alt="{{ $personal->first_name }}" width="50" class="rounded-circle">
                                    <h5 class="teacher-name">{{ $personal->first_name }} {{ $personal->last_name }}
                                    </h5>
                                    <p class="teacher-position">{{ $personal->position }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-test mt-5">
        <div class="container">
            <div class="background-color-EBF1EE p-4 rounded">
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/test.webp') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-12 col-lg-6 d-flex flex-column justify-content-between">
                        <div class="m-3">
                            <div class="title mb-3">
                                Узнайте уровень своей гибкости и получите персональную программу занятий по йоге
                            </div>
                            <div class="desc mb-3">
                                Пройдите тест и приходите на первое занятие бесплатно
                            </div>
                        </div>

                        <!-- Кнопка внизу колонки -->
                        <div class="m-3">
                            <button class="btn button" data-bs-toggle="modal" data-bs-target="#testModal">
                                Пройти тест <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="otziv mt-5">
        <div class="container d-flex justify-content-center">
            <div class="otziv-wrapper" style="width:560px; height:800px; position:relative;">
                <iframe
                    style="width:100%; height:100%; border:1px solid #e6e6e6; border-radius:8px; box-sizing:border-box;"
                    src="https://yandex.ru/maps-reviews-widget/219103386750?comments">
                </iframe>
                <a href="https://yandex.ru/maps/org/istokiya/219103386750/" target="_blank"
                    style="text-decoration:none; color:#b3b3b3; font-size:10px; font-family:YS Text,sans-serif; 
                position:absolute; bottom:8px; width:100%; text-align:center; left:0; overflow:hidden; 
                text-overflow:ellipsis; white-space:nowrap; padding:0 16px;">
                    ИстокиЯ на карте Краснодарского края — Яндекс Карты
                </a>
            </div>
        </div>
    </div>
    <div class="photo-gallery">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="text text-center">
                    <h2 class="section-title">Фотогалерея</h2>
                    <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
                </div>
            </div>
            <div class="container mt-5">
                <!-- Обертка для свайпера и стрелок -->
                <div class="gallery3-wrapper position-relative">
                    <!-- Стрелки теперь СНАРУЖИ свайпера -->
                    <div class="swiper-button-prev gallery3-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </div>
                    <div class="swiper-button-next gallery3-next">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </div>

                    <!-- Сам свайпер БЕЗ стрелок внутри -->
                    <div class="swiper gallery3-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($galleries as $photo)
                                <div class="swiper-slide">
                                    <a href="{{ asset('storage/' . $photo->image) }}" class="gallery3-item"
                                        data-lg-size="1600-900">
                                        <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top"
                                            alt="{{ $photo->title }}">
                                    </a>
                                </div>
                            @endforeach
                            {{-- 
                            <div class="swiper-slide">
                                <a href="{{ asset('images/swiper-img.webp') }}" class="gallery3-item"
                                    data-lg-size="1600-900">
                                    <img src="{{ asset('images/swiper-img.webp') }}" alt="Фото"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ asset('images/swiper-img.webp') }}" class="gallery3-item"
                                    data-lg-size="1600-900">
                                    <img src="{{ asset('images/swiper-img.webp') }}" alt="Фото"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ asset('images/swiper-img.webp') }}" class="gallery3-item"
                                    data-lg-size="1600-900">
                                    <img src="{{ asset('images/swiper-img.webp') }}" alt="Фото"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ asset('images/swiper-img.webp') }}" class="gallery3-item"
                                    data-lg-size="1600-900">
                                    <img src="{{ asset('images/swiper-img.webp') }}" alt="Фото"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ asset('images/swiper-img.webp') }}" class="gallery3-item"
                                    data-lg-size="1600-900">
                                    <img src="{{ asset('images/swiper-img.webp') }}" alt="Фото"
                                        class="img-fluid">
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.recording-block')
    <div class="questions mt-5">
        <div class="container">
            <div class="d-flex flex-column">
                <div class="title mb-5">
                    Часто задаваемые вопросы
                </div>
                <div class="accordion" id="accordionExample">
                    @foreach ($questions as $index => $question)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index + 1 }}">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index + 1 }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $index + 1 }}">
                                    {{ $question->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index + 1 }}"
                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                aria-labelledby="heading{{ $index + 1 }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! nl2br(e($question->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Блок контактов --}}
    @include('partials.contacts-block')

    {{-- Модальное окно теста --}}
    @include('partials.modal-test')

    @include('partials.footer')

    {{-- Скрипт теста загружается после Bootstrap --}}
    @vite(['resources/js/yoga-test.js'])

</body>

</html>
