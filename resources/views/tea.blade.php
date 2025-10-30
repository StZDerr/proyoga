<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПроЙога</title>
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/tea.css', 'resources/js/recording-form.js', 'resources/css/recording.css'])
</head>

<body>

    @include('partials.navbar')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container">
                {{ Breadcrumbs::render('tea') }}
                <div class="title">
                    Чайная зона “Исток и Я”
                </div>
                <div class="desc">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa voluptatum, facilis
                    accusamus explicabo nihil deserunt minus odit molestiae dolore quis.
                </div>
            </div>
        </div>
        <div class="containerMain">
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
    </div>
    @include('partials.recording-block')
    @include('partials.footer')

</body>

</html>
