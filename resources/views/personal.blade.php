<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/css/base.css', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/contacts-block.css', 'resources/css/recording.css', 'resources/css/personal.css', 'resources/css/arrow.css', 'resources/css/cookies.css', 'resources/js/app.js', 'resources/js/base.js', 'resources/js/navbar.js', 'resources/js/arrow.js', 'resources/js/cookies.js', 'resources/js/recording-form.js', 'resources/js/lazy-iframe.js', 'resources/js/personal.js'])
</head>

<body>
    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container">
                {{ Breadcrumbs::render('personal', $personal) }}
                <div class="title">{{ $personal->first_name }}
                    {{ $personal->middle_name ? $personal->middle_name . ' ' : '' }}{{ $personal->last_name }}</div>
                <div class="desc">
                    Профиль инструктора и подробная информация о практике и направлениях занятий.
                </div>
            </div>
        </div>
        <div class="about py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-12 mb-4 mb-lg-0 text-center">
                        @if ($personal->photo)
                            <img src="{{ asset('storage/' . $personal->photo) }}"
                                alt="{{ $personal->first_name }} {{ $personal->last_name }}"
                                class="img-fluid rounded-4 shadow" width="420" height="420" loading="lazy">
                        @else
                            <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="ИстокиЯ" class="img-fluid"
                                width="220" height="200" loading="lazy">
                        @endif
                    </div>
                    <div class="col-lg-7 col-12 about-text">
                        {{-- <div class="title">
                            {{ $personal->first_name }} {{ $personal->last_name }}
                            @if ($personal->middle_name)
                                <span class="text-muted">{{ $personal->middle_name }}</span>
                            @endif
                        </div> --}}
                        <div class="desc mt-3">
                            <strong>{{ $personal->position }}</strong>
                        </div>

                        @if (!empty($personal->description))
                            <div class="desc mt-3">
                                {!! nl2br(e($personal->description)) !!}
                            </div>
                        @else
                            <div class="desc mt-3 text-muted">
                                Описание скоро появится. Следите за обновлениями!
                            </div>
                        @endif

                        <div class="mt-4 d-flex flex-wrap gap-3 personal-actions">
                            <a href="{{ route('calendar') }}" class="btn btn-more">Расписание</a>
                            <a href="{{ route('recording') }}" class="btn button">Записаться на занятие</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @if ($personal->photos->isNotEmpty())
        <div class="photo-gallery">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text text-center">
                        <h2 class="section-title">Фотографии</h2>
                        <span>Моменты с занятий и мастер-классов</span>
                    </div>
                </div>
                <div class="container mt-4">
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

                        <div class="swiper personal-gallery-swiper">
                            <div class="swiper-wrapper align-items-center">
                                @foreach ($personal->photos as $photo)
                                    <div class="swiper-slide">
                                        <a href="{{ asset('storage/' . $photo->path) }}" class="gallery3-item">
                                            <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top"
                                                alt="{{ $personal->first_name }} {{ $personal->last_name }}"
                                                loading="lazy" width="800" height="600">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="personal-gallery-pagination mt-3 text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('partials.recording-block')
    @include('partials.contacts-block')
    @include('partials.footer')
</body>

</html>
