<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/tea.css', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container">
                {{ Breadcrumbs::render('tea') }}
                <div class="title">
                    Чайная зона “ИстокиЯ”
                </div>
            </div>
        </div>
        <div class="containerMain">
            <div class="container">
                <div class="parent">
                    <div class="text-block div1">
                        <div class="title">Чай по вашему состоянию</div>
                        <p class="text">
                            Хотите бодрости, мягкого тонуса или глубокого расслабления? Подберём чай под ваше утро,
                            вечер или восстановление после тренировки.
                        </p>
                    </div>
                    <div class="image-block div2">
                        <img src="{{ asset('images/5213289698720159661.webp') }}" alt="Tea Zone" />
                    </div>
                    <div class="text-block other div3">
                        <div class="title">Коллекция вкусов</div>
                        <p class="text">
                            Зелёные и белые чаи, улуны, красные, пуэры, габа и гречишный — каждый со своим характером и
                            настроением: зелёный бодрит и освежает, белый мягко успокаивает, улуны дают баланс (от
                            цветочной лёгкости до тёплой прожарки).
                        </p>
                    </div>
                    <div class="text-block other div4">
                        <div class="title">Завариваем правильно</div>
                        <p class="text">
                            Учитываем температуру воды, время и посуду, чтобы чай раскрывался мягко и без горечи. Если
                            захотите — покажем лист, аромат и расскажем краткую историю сорта.
                        </p>
                    </div>
                    <div class="image-block div5">
                        <img src="{{ asset('images/5213289698720159687.webp') }}" alt="Tea Zone" />
                    </div>
                    <div class="text-block div6">
                        <div class="title">Ритуал, а не “просто чай”</div>
                        <p class="text">
                            Здесь чай — это маленькая церемония: замедлиться, согреться, выдохнуть и почувствовать опору
                            внутри.
                        </p>
                    </div>
                </div>
            </div>
            <div class="container">
                <h2 class="subTitle">О чайной зоне</h2>
                <div class="text-block">
                    <p class="text">
                        Эта зона служит не только местом для отдыха, но и площадкой для
                        неформального общения, обмена поддержкой и хорошим настроением. Время,
                        проведенное здесь, помогает снизить уровень тревожности, снять стресс
                        и укрепить внутренние ресурсы для преодоления жизненных трудностей.
                    </p>
                    <p class="text">
                        Здесь можно просто молча выдохнуть, согреться и «переключить» нервную систему из режима спешки в
                        режим присутствия. Чайная пауза помогает мягко завершить практику или, наоборот, настроиться на
                        занятие — без резких стимулов и лишней суеты..
                    </p>
                    <p class="text">
                        А ещё это пространство маленьких привычек, которые собирают нас по кусочкам: тёплая чашка в
                        руках,
                        спокойный разговор, ощущение безопасности и принятия. Именно из таких простых моментов
                        складывается
                        устойчивость — когда внутри появляется больше ясности, спокойствия и сил для своих задач.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5">
        @include('partials.recording-block')
    </div>
    @include('partials.footer')

</body>

</html>
