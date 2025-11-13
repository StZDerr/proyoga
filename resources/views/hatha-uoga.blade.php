<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/hatha-uoga.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/js/hatha-uoga.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="containerMain">
        <div class="container">
            {{ Breadcrumbs::render('subSubCategoryDetail', $subSubCategory) }}
        </div>
        <div class="container serviceBanner">
            <div class="serviceContent">

                <h1 class="mainTitle">{{ $subSubCategory->title }}</h1>
                <p class="text">
                    {{ $subSubCategory->description ?? '"Исток и Я" - Твой путь к себе начинается с Истока. Здесь соединяются тело, дыхание, звук, осознанность и общение.' }}
                </p>
                <a href="#recording" class="button bdi">Получить пробный урок</a>
            </div>
            <img src="{{ asset('storage/' . $subSubCategory->image) }}" alt="{{ $subSubCategory->title }}"
                class="serviceIMG" />
        </div>
        <div class="container">
            <h2 class="subTitle">О {{ $subSubCategory->prepositional_title }}</h2>
            <p class="text other">
                {{ $subSubCategory->about ?? 'Данное направление включает в себя полный комплекс взаимодействия на физическом и ментальном уровне через выполнение асан, дыхательных упражнений (пранаям), мудр и концентрацию внимания посредством медитации. Это направление стало основоположником многих популярных современных направлений йоги.' }}
            </p>
            <div class="gallery">
                @if ($subSubCategory->photos->isNotEmpty())
                    <div class="photo-gallery">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="text text-center">
                                    <h2 class="section-title">Фотогалерея</h2>
                                    <span>
                                        Каждый кадр — вдох, наполненный светом, движением и гармонией.
                                        Прикоснитесь к миру {{ $subSubCategory->title }}.
                                    </span>
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
                                            @foreach ($subSubCategory->photos as $photo)
                                                <div class="swiper-slide">
                                                    <a href="{{ asset('storage/' . $photo->image) }}"
                                                        class="gallery3-item">
                                                        <img src="{{ asset('storage/' . $photo->image) }}"
                                                            class="card-img-top" alt="{{ $subSubCategory->title }}"
                                                            loading="lazy" width="800" height="600">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('photo-galleries') }}" class="btn btn-more mt-4">
                            Смотреть все <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif

            </div>
            @if ($subSubCategory->benefits && count($subSubCategory->benefits) > 0)
                <h2 class="subTitle">Польза {{ $subSubCategory->genitive_title }}</h2>
                @foreach ($subSubCategory->benefits as $benefitGroup)
                    @if (is_array($benefitGroup) && isset($benefitGroup['title']) && isset($benefitGroup['benefits']))
                        {{-- Новая структура с группами --}}
                        <div class="benefit-group mb-4">
                            <h3 class="textTitle">{{ $benefitGroup['title'] }}</h3>
                            @foreach ($benefitGroup['benefits'] as $benefit)
                                <div class="text other"> {{ $benefit }}</div>
                            @endforeach
                        </div>
                    @elseif (is_string($benefitGroup))
                        {{-- Совместимость со старой структурой (простой массив строк) --}}
                        <div class="textTitle">{{ $benefitGroup }}</div>
                    @else
                        {{-- Обработка некорректных данных --}}
                        <div class="textTitle">
                            {{ is_string($benefitGroup) ? $benefitGroup : json_encode($benefitGroup) }}</div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <div class="calendar mt-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text">
                    <h2 class="section-title">Расписание занятий</h2>
                    <span>Выберите удобное для вас время занятий</span>
                </div>
                <a href="{{ route('calendar') }}" class="btn button">
                    Смотреть полностью
                </a>
            </div>
            <iframe class="aeCustomWidget"
                src="//appevent.ru/widget/embeded?widget_key=8d72037d71fe2300577cb286d7d4fae7&hall_id=24709"
                width="100%" height="1120px" style="background: #ffffff;border: none;"></iframe>
        </div>
    </div>
    <div class="mb-5">
        @include('partials.recording-block')
    </div>
    @include('partials.footer')

</body>

</html>
