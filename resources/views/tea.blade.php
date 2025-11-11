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
        <div class="zaglyshka mt-5">
            <div class="container">
                <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Icon" class="img-fluid" width="144"
                    height="120" />
                <div class="title">Данный раздел находится в разработке</div>
            </div>
        </div>
        <!-- <div class="containerMain">
            <div class="container">
                <div class="parent">
                    <div class="text-block div1">
                        <div class="title">Заголовок 1</div>
                        <p class="text">
                            Внутри студии создана атмосфера уюта и спокойствия, что помогает
                            сосредоточиться на
                        </p>
                    </div>
                    <div class="image-block div2">
                        <img src="{{ asset('images/tea-zone.webp') }}" alt="Tea Zone" />
                    </div>
                    <div class="text-block other div3">
                        <div class="title">Заголовок 1</div>
                        <p class="text">
                            Внутри студии создана атмосфера уюта и спокойствия, что помогает
                            сосредоточиться на
                        </p>
                    </div>
                    <div class="text-block other div4">
                        <div class="title">Заголовок 1</div>
                        <p class="text">
                            Внутри студии создана атмосфера уюта и спокойствия, что помогает
                            сосредоточиться на
                        </p>
                    </div>
                    <div class="image-block div5">
                        <img src="{{ asset('images/tea-zone.webp') }}" alt="Tea Zone" />
                    </div>
                    <div class="text-block div6">
                        <div class="title">Заголовок 1</div>
                        <p class="text">
                            Внутри студии создана атмосфера уюта и спокойствия, что помогает
                            сосредоточиться на
                        </p>
                    </div>
                </div>
            </div>
            <div class="container">
                <h2 class="subTitle">О чайной зоне</h2>
                <p class="text">
                    Эта зона служит не только местом для отдыха, но и площадкой для
                    неформального общения, обмена поддержкой и хорошим настроением. Время,
                    проведенное здесь, помогает снизить уровень тревожности, снять стресс
                    и укрепить внутренние ресурсы для преодоления жизненных трудностей.
                </p>
                <p class="text">
                    Эта зона служит не только местом для отдыха, но и площадкой для
                    неформального общения, обмена поддержкой и хорошим настроением. Время,
                    проведенное здесь, помогает снизить уровень тревожности, снять стресс
                    и укрепить внутренние ресурсы для преодоления жизненных трудностей.
                </p>
                <div class="text-block">
                    <p class="text">
                        Эта зона служит не только местом для отдыха, но и площадкой для
                        неформального общения, обмена поддержкой и хорошим настроением.
                        Время, проведенное здесь, помогает снизить уровень тревожности,
                        снять стресс и укрепить внутренние ресурсы для преодоления жизненных
                        трудностей.
                    </p>
                    <p class="text">
                        Эта зона служит не только местом для отдыха, но и площадкой для
                        неформального общения, обмена поддержкой и хорошим настроением.
                        Время, проведенное здесь, помогает снизить уровень тревожности,
                        снять стресс и укрепить внутренние ресурсы для преодоления жизненных
                        трудностей.
                    </p>
                </div>
            </div>
        </div>
    </div> -->
        <div class="mb-5">
            @include('partials.recording-block')
        </div>
        @include('partials.footer')

</body>

</html>
