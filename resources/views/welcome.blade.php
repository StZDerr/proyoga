<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Preconnect для Google Fonts (оптимизация загрузки) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Preload критичных ресурсов --}}
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap">

    {{-- Асинхронная загрузка шрифтов --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
        rel="stylesheet" media="print" onload="this.media='all'">

    {{-- Fallback для браузеров без JS --}}
    <noscript>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Tenor+Sans:wght@400&display=swap"
            rel="stylesheet">
    </noscript>

    {{-- Общие стили и JS через Vite (оптимизировано) --}}
    @vite(['resources/css/app.css', 'resources/css/base.css', 'resources/css/performance.css', 'resources/css/welcome.css', 'resources/css/contacts-block.css', 'resources/css/recording.css', 'resources/css/modal-test.css', 'resources/js/app.js', 'resources/js/base.js', 'resources/js/welcome_new.js', 'resources/js/recording-form.js', 'resources/js/yoga-test.js', 'resources/js/promotion-modal.js', 'resources/js/spin-mask.js', 'resources/js/wheel.js', 'resources/js/lazy-iframe.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    <div class="background-gor">
        <div class="container text-center py-5">
            <div class="main">
                <h1 class="display-4 mb-3 title-text">Центр физического и ментального здоровья</h1>
                <p class="lead mb-4">ИстокиЯ</p>
                <div class="lead-subtext">
                    25 направлений по единому абонементу<br>
                    Занятия для взрослых и детей<br>
                    Массажный кабинет и психолог<br>
                    Чайная зона
                </div>
                <div class="full-width-divider" aria-hidden="true"></div>
                <div class="lead-description">
                    «ИстокиЯ» — это точка возврата.
                    К ресурсности. К осознанности. К себе.
                    Здесь не нужно быть “правильным” — достаточно быть настоящим.
                </div>
                <div class="spin-cta text-center mt-4">
                    <button class="spin-cta-button" type="button" aria-label="Крутить колесо">
                        <span class="spin-cta-title">КРУТИТЬ КОЛЕСО</span>
                        <span class="spin-cta-subtitle">ПОЛУЧИ ПОДАРОК</span>
                    </button>
                </div>
                <div class="promo-countdown mt-3">ДО КОНЦА АКЦИИ</div>
                <div class="countdown-wrapper mt-3" aria-hidden="false">
                    <div class="countdown-inner" id="promo-timer">
                        <div class="countdown-item">
                            <div class="count-number" id="count-days">00</div>
                            <div class="count-label">дней</div>
                        </div>
                        <div class="countdown-item">
                            <div class="count-number" id="count-hours">00</div>
                            <div class="count-label">часов</div>
                        </div>
                        <div class="countdown-item">
                            <div class="count-number" id="count-minutes">00</div>
                            <div class="count-label">минут</div>
                        </div>
                        <div class="countdown-item">
                            <div class="count-number" id="count-seconds">00</div>
                            <div class="count-label">секунд</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="marquee-wrapper">
        <!-- Первая лента -->
        <div class="marquee marquee-light">
            <div class="marquee-content">
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Функциональные тренировки</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Мастер-классы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Растяжка</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Аэройога</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Пилатес</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Танцы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Джампинг</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Массаж</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Услуги психолога</span>
                </div>

                <!-- Повторяем элементы для бесконечного эффекта -->
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Функциональные тренировки</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Мастер-классы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Растяжка</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Аэройога</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Пилатес</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Танцы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Джампинг</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Массаж</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Услуги психолога</span>
                </div>
            </div>
        </div>

        <!-- Вторая лента -->
        <div class="marquee marquee-dark">
            <div class="marquee-content">
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Функциональные тренировки</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Мастер-классы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Растяжка</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Аэройога</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Пилатес</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Танцы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Джампинг</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Массаж</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Услуги психолога</span>
                </div>

                <!-- Повторяем элементы для бесконечного эффекта -->
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Функциональные тренировки</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Мастер-классы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Растяжка</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Аэройога</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Пилатес</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Танцы</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Джампинг</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Массаж</span>
                </div>
                <div class="marquee-item">
                    <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="Icon" width="39"
                        height="43" />
                    <span>Услуги психолога</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center py-5">
        <div class="main">
            {{-- Swiper слайдер --}}
            <div class="swiper my-custom-swiper-container mt-5">
                <div class="swiper-button-prev stock-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-next stock-next">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </div>
                <div class="swiper-wrapper">
                    @foreach ($promotions as $promotion)
                        <div class="swiper-slide">
                            <div class="card shadow-sm promotion-card" data-title="{{ $promotion->title }}"
                                data-description="{{ $promotion->description }}"
                                data-photo="{{ asset('storage/' . $promotion->photo) }}"
                                data-start="{{ $promotion->start_date }}" data-end="{{ $promotion->end_date }}">
                                <img src="{{ asset('storage/' . $promotion->photo) }}" alt="{{ $promotion->title }}"
                                    loading="lazy" width="800" height="450">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>
            <div class="swiper-info-text">
                Твой путь к себе начинается с Истока
            </div>
            <a href="{{ route('calendar') }}" class="button-bid button-text button mt-4">
                Расписание занятий
            </a>
            <a href="{{ route('price-list') }}" class="btn button-text button mt-4">
                Наши цены
            </a>
        </div>
    </div>
    {{-- </div> --}}
    @if ($stories->isNotEmpty())
        <div class="stories-container">
            <button class="nav-btn nav-prev" id="navPrev">&lt;</button>
            <button class="nav-btn nav-next" id="navNext">&gt;</button>

            <div class="stories-wrapper" id="storiesWrapper">
                <!-- ТВОИ ИСТОРИИ -->
                @foreach ($stories as $story)
                    <div class="story">
                        @foreach ($story->media as $media)
                            <div class="story-media" data-src="{{ asset('storage/' . $media->path) }}"></div>
                        @endforeach
                        <img src="{{ asset('storage/' . $story->preview) }}" alt="{{ $story->title }}"
                            class="avatar" loading="lazy" width="80" height="80" />
                        <p>{{ $story->title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ЛАЙТБОКС -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-content">
            <div class="progress-container"></div>
            <div class="lightbox-media-container"></div>
            <button class="lightbox-close">×</button>
        </div>
    </div>
    <div class="about py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 about-img mb-4 mb-lg-0 text-center">
                    <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Icon" class="img-fluid"
                        width="80" height="80" />
                </div>
                <div class="col-lg-6 col-12 about-text">
                    <div class="title">
                        "ИстокиЯ" — Твой путь к себе начинается с Истока.
                        Здесь соединяются тело, дыхание, звук, осознанность и общение.
                    </div>
                    <div class="desc mt-3">
                        В “ИстокиЯ” проходят занятия по йоге, пилатесу, дыхательным и телесным практикам,
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
            <div class="row align-items-center">
                <div class="col-12 col-lg-9">
                    <div class="text">
                        <h2 class="section-title">Направления занятий</h2>
                        <span>Мы поможем подобрать направление, которое подходит именно Вам</span>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="button d-flex justify-content-center h-100 align-items-center mt-3">
                        <a href="{{ route('direction') }}" class="text-decoration-none text-white">
                            Все направления
                        </a>
                    </div>
                </div>
            </div>
            <div class="gallery3-wrapper position-relative mt-2 mb-3">
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

                <div class="swiper directions-swiper">
                    <div class="swiper-wrapper align-items-center">
                        @foreach ($mainCategories as $mainCategory)
                            @foreach ($mainCategory->subCategories as $subCategory)
                                <div class="swiper-slide">
                                    <a href="{{ route('PodDirection', $subCategory->slug) }}"
                                        class="text-decoration-none text-dark">
                                        <div class="card-directions">
                                            <div class="card-image">
                                                @if ($subCategory->image)
                                                    <img src="{{ asset('storage/' . $subCategory->image) }}"
                                                        alt="{{ $subCategory->title }}" loading="lazy"
                                                        width="600" height="338" class="card-directions-img" />
                                                @else
                                                    <img src="{{ asset('images/directions-background.webp') }}"
                                                        alt="directions-background" loading="lazy" width="600"
                                                        height="338" class="card-directions-img" />
                                                @endif
                                            </div>

                                            <div class="card-info">
                                                <div
                                                    class="d-flex justify-content-between align-items-start card-info-top">
                                                    <div class="card-title">
                                                        {{ $subCategory->title }}
                                                    </div>
                                                    <div class="arrow">
                                                        <i class="bi bi-arrow-right fs-4"></i>
                                                    </div>
                                                </div>
                                                {{-- <div class="card-desc">
                                                    {{ Str::limit(strip_tags($subCategory->description ?? ''), 20, '') }}
                                                </div> --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-space">
        <div class="container">
            <div class="title">
                Наше пространство создано для всех, кто ценит комфорт, уют и заботу <br>
                <span> не только о своём теле, но и душе.</span>
            </div>
            <div class="text">
                Внутри студии создана атмосфера уюта и спокойствия, что помогает сосредоточиться на занятиях.
                Светлые
                тона и приятные ароматы создают замечательное настроение.
                Вы найдете все необходимое для эффективной тренировки и расслабления после неё.
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/people.svg') }}" alt="people" width="80"
                                height="80" />
                        </div>
                        <div class="about-space-features-text">
                            Разные направления физического и духовного развития
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/ClipPathGroup.svg') }}" alt="people" width="80"
                                height="80" />
                        </div>
                        <div class="about-space-features-text">
                            Два зала, чайная зона и собственный автобус для путешествий
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="about-space-features text-center">
                        <div class="svg mb-3">
                            <img src="{{ asset('images/svg/comp.svg') }}" alt="people" loading="lazy"
                                width="80" height="80" />
                        </div>
                        <div class="about-space-features-text">
                            Здесь соединяются тело, дыхание, звук, осознанность и общение
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="retreats mt-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-7">
                    <div class="title">
                        Выездные сессии “ИстокиЯ - путешествия к себе”
                    </div>
                    <div class="desc mt-3">
                        Выездные сессии — «Путешествие к себе»
                        Иногда, чтобы почувствовать перемены, нужно просто выйти из привычных стен. Выездные сессии
                        «ИстокиЯ» — это практика на природе, где движение, дыхание и тишина собирают вас обратно в
                        единое целое.
                    </div>
                    <div class="desc mt-3">
                        Что обычно входит:
                    </div>
                    <div class="desc mt-3">
                        <ul>
                            <li> Йога/мягкая растяжка под уровень группы</li>
                            <li> Дыхательные и расслабляющие практики, медитация/настройка</li>
                            <li> Тёплое общение и поддержка группы — то самое «про людей», которое у нас важно так же,
                                как практика</li>
                        </ul>
                    </div>
                    <div class="desc mt-3">
                        Для кого: если вы устали от однообразия, хотите перезагрузить нервную систему, вернуть ясность и
                        почувствовать тело живым — вам сюда.
                    </div>
                    <a href="{{ route('tea') }}" class="btn btn-more mt-4">
                        Подробнее <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12 col-xl-5 text-end mt-5">
                    <img src="{{ asset('images/1.webp') }}" alt="Off-siteSessions" loading="lazy" width="500"
                        height="400">
                </div>
            </div>
        </div>
    </div>
    @if ($personals->isNotEmpty())
        <div class="teachers mt-5">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text">
                        <h2 class="section-title">Наши преподаватели</h2>
                        <span>Доверьтесь команде профессионалов</span>
                    </div>
                </div>
                <div class="teachers-swiper-container mt-4 position-relative">
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
                                    @if (!empty($personal->slug))
                                        <a href="{{ route('personal', $personal) }}"
                                            class="text-decoration-none text-dark">
                                            <div class="teacher-card">
                                                <img src="{{ asset('storage/' . $personal->photo) }}"
                                                    alt="{{ $personal->first_name }}" width="50" height="50"
                                                    class="rounded-circle" loading="lazy">
                                                <h5 class="teacher-name">{{ $personal->first_name }}
                                                    {{ $personal->last_name }}
                                                </h5>
                                                <p class="teacher-position">{{ $personal->position }}</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="teacher-card">
                                            <img src="{{ asset('storage/' . $personal->photo) }}"
                                                alt="{{ $personal->first_name }}" width="50" height="50"
                                                class="rounded-circle" loading="lazy">
                                            <h5 class="teacher-name">{{ $personal->first_name }}
                                                {{ $personal->last_name }}
                                            </h5>
                                            <p class="teacher-position">{{ $personal->position }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="main-test mt-5">
        <div class="container">
            <div class="background-color-EBF1EE p-4 rounded">
                <div class="row">
                    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('images/2.webp') }}" alt="" class="img-fluid">
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
    @if ($galleries->isNotEmpty())
        <div class="photo-gallery">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text text-center">
                        <h2 class="section-title">Фотогалерея</h2>
                        <span>Каждый кадр — вдох, наполненный светом, движением и гармонией. Прикоснитесь к миру
                            йоги.</span>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="gallery3-wrapper position-relative">
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

                        <div class="swiper gallery3-swiper">
                            <div class="swiper-wrapper align-items-center">
                                @foreach ($galleries as $photo)
                                    <div class="swiper-slide">
                                        <a href="{{ asset('storage/' . $photo->image) }}" class="gallery3-item">
                                            <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top"
                                                alt="{{ $photo->title }}" loading="lazy" width="800"
                                                height="600">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('photo-galleries') }}" class="btn btn-more mt-4">
                Смотреть все
            </a>
        </div>
    @endif


    @include('partials.recording-block')

    {{-- Блок статей --}}
    @if ($articles->isNotEmpty())
        <div class="articles-section mt-5 py-5">
            <div class="container">
                <div class="title mb-5 text-center">
                    Полезные статьи
                </div>
                <div class="row g-4">
                    @foreach ($articles as $article)
                        <div class="col-lg-4 col-md-6">
                            <div class="article-card h-100">
                                @if ($article->image)
                                    <div class="article-image">
                                        <img src="{{ asset('storage/' . $article->image) }}"
                                            alt="{{ $article->title }}" class="img-fluid">
                                    </div>
                                @endif
                                <div class="article-content p-4">
                                    <h3 class="article-title">{{ $article->title }}</h3>
                                    <p class="article-excerpt text-muted">
                                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="article-date text-muted small">
                                            {{ $article->created_at->format('d.m.Y') }}
                                        </span>
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="btn btn-link text-decoration-none">
                                            Читать далее
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('articles.index') }}" class="btn btn-more mt-4">
                        Все статьи
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if ($questions->isNotEmpty())
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
                                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index + 1 }}"
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
    @endif
    {{-- Блок контактов --}}
    @include('partials.contacts-block')
    @include('partials.footer')

    {{-- Модальное окно теста --}}
    @include('partials.promotion-modal')
    @include('partials.modal-test')

    @if (!empty($showSpin) && $showSpin)
        <div class="spin-popup" id="spinPopup" aria-hidden="true" role="dialog" aria-labelledby="spinPopupTitle">
            <div class="spin-popup__backdrop"></div>
            <div class="spin-popup__content">
                <button class="spin-popup__close" type="button" aria-label="Закрыть">×</button>
                <div class="spin" role="document">
                    <div class="container">
                        <div class="spin-layout">
                            <div class="spin-left">
                                <div class="spin-visual">
                                    <div class="wheel-frame" role="img" aria-label="Колесо удачи">
                                        <div id="wheelDynamic" class="wheel-dynamic" aria-hidden="true"></div>
                                        <div class="wheel-center" aria-hidden="true">
                                            <img src="{{ asset('images/podarok.png') }}" alt="Подарок"
                                                class="wheel-center-img" />
                                        </div>
                                        <svg class="wheel-pointer" aria-hidden="true" width="105" height="120"
                                            viewBox="0 0 105 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_1447_1535)">
                                                <path
                                                    d="M55.1274 101.207L8.12988 0C46.3993 13.3828 82.8223 5.57617 96.2502 0L55.1274 101.207Z"
                                                    fill="#CCFF3F" />
                                                <path
                                                    d="M55.1274 101.207L8.12988 0C46.3993 13.3828 82.8223 5.57617 96.2502 0L55.1274 101.207Z"
                                                    stroke="white" />
                                            </g>
                                            <defs>
                                                <filter id="filter0_d_1447_1535" x="0.000447273" y="0" width="104.379"
                                                    height="119.778" filterUnits="userSpaceOnUse"
                                                    color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                        result="hardAlpha" />
                                                    <feOffset dy="10.4415" />
                                                    <feGaussianBlur stdDeviation="4.06472" />
                                                    <feComposite in2="hardAlpha" operator="out" />
                                                    <feColorMatrix type="matrix"
                                                        values="0 0 0 0 0.101961 0 0 0 0 0.254902 0 0 0 0 0.317647 0 0 0 0.52 0" />
                                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                                        result="effect1_dropShadow_1447_1535" />
                                                    <feBlend mode="normal" in="SourceGraphic"
                                                        in2="effect1_dropShadow_1447_1535" result="shape" />
                                                </filter>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="spin-right">
                                <div class="spin-form">
                                    <div class="spin-title">ПОЛУЧИТЕ ПОДАРОК</div>
                                    <div class="spin-subtitle">
                                        Введите номер вашего телефона,<br>
                                        вращайте колесо и получите бонус!
                                    </div>
                                    <form class="spin-form-fields" action="{{ route('spin') }}" method="POST">
                                        @csrf
                                        <input type="tel" name="phone" class="spin-input"
                                            placeholder="Введите номер телефона" required />
                                        <div class="spin-error" role="alert" aria-live="polite"></div>
                                        <label class="spin-consent">
                                            <input type="checkbox" name="agree" value="1" required />
                                            <span>Я согласен(-на) с <a href="{{ route('privacy-policy') }}">политикой
                                                    конфиденциальности</a></span>
                                        </label>
                                        <button type="submit" class="spin-button" disabled>Вращать колесо</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="spin-modal" aria-hidden="true" role="dialog" aria-labelledby="spinModalTitle">
        <div class="spin-modal__backdrop"></div>
        <div class="spin-modal__content">
            <button class="spin-modal__close" type="button" aria-label="Закрыть">×</button>
            <div class="spin-modal__title" id="spinModalTitle">Ваш выигрыш</div>
            <div class="spin-modal__prize" data-spin-prize>—</div>
            <div class="spin-modal__phone">Телефон: <span data-spin-phone>—</span></div>
            <div class="spin-modal__note">
                Наш менеджер свяжется с вами для подтверждения подарка.
            </div>
            <button class="spin-modal__action" type="button">Отлично</button>
        </div>
    </div>

    @stack('scripts')

</body>

</html>
