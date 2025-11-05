<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/price-list.css', 'resources/js/price-list.js', 'resources/css/hatha-uoga.css'])
</head>

<body>

    @include('partials.navbar')
    <div class="containerMain">
        <div class="container serviceBanner">
            <div class="serviceContent">
                {{ Breadcrumbs::render('subSubCategoryDetail', $subSubCategory) }}
                <h1 class="mainTitle">{{ $subSubCategory->title }}</h1>
                <p class="text">
                    {{ $subSubCategory->description ?? '"Исток и Я" - Твой путь к себе начинается с Истока. Здесь соединяются тело, дыхание, звук, осознанность и общение.' }}
                </p>
                <a href="#" class="button bdi">Получить пробный урок</a>
            </div>
            <img src="{{ asset('storage/' . $subSubCategory->image) }}" alt="{{ $subSubCategory->title }}"
                class="serviceIMG" />
        </div>
        <div class="container">
            <h2 class="subTitle">О {{ $subSubCategory->title }}</h2>
            <p class="text other">
                {{ $subSubCategory->about ?? 'Данное направление включает в себя полный комплекс взаимодействия на физическом и ментальном уровне через выполнение асан, дыхательных упражнений (пранаям), мудр и концентрацию внимания посредством медитации. Это направление стало основоположником многих популярных современных направлений йоги.' }}
            </p>

            @if ($subSubCategory->benefits && count($subSubCategory->benefits) > 0)
                <h2 class="subTitle">Польза {{ $subSubCategory->title }}</h2>
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
