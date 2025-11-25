<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/about.css', 'resources/js/about.js', 'resources/js/recording-form.js', 'resources/css/contacts-block.css', 'resources/css/recording.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/js/lazy-iframe.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container">
                {{ Breadcrumbs::render('about') }}
                <div class="title">
                    О Центре
                </div>
                <div class="desc">
                    "ИстокиЯ" - Твой путь к себе начинается с Истока.
                    Здесь соединяются тело, дыхание, звук, осознанность и общение.
                </div>
            </div>
        </div>
        <div class="about py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-12 about-img mb-4 mb-lg-0 text-center text-lg-start">
                        <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Icon" class="img-fluid"
                            width="144" height="120" />
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
                            <img src="{{ asset('images/svg/comp.svg') }}" alt="people" width="80"
                                height="80" />
                        </div>
                        <div class="about-space-features-text">
                            Здесь соединяются тело, дыхание, звук, осознанность и общение
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="teachers mt-5">
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
    </div> -->
    @include('partials.recording-block')
    @include('partials.contacts-block')
    @include('partials.footer')

</body>

</html>
