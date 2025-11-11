<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('components.seo-meta')
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&family=Russo+One&display=swap"
        rel="stylesheet">
    <title>404</title>
    @vite(['resources/css/404.css'])

</head>

<body>
    <main class="page">
        <div class="container">
            <div>
                <div class="starsec"></div>
                <div class="starthird"></div>
                <div class="starfourth"></div>
                <div class="starfifth"></div>
            </div>
            <div class="lamp__wrap">
                <div class="lamp">
                    <div class="cable"></div>
                    <div class="cover"></div>
                    <div class="in-cover">
                        <div class="bulb"></div>
                    </div>
                    <div class="light"></div>
                </div>
            </div>
            <section class="error">
                <div class="error__content">
                    <div class="error__message message">
                        <h1 class="message__title"><span id="one">4</span><span id="two">0</span><span
                                id="three">4</span></h1>
                    </div>
                    <div class="error__nav e-nav">
                        <a href="/" class="e-nav__link"><i class="fas fa-arrow-left"></i> вернуться обратно</a>
                    </div>
                </div>
            </section>

        </div>
    </main>
</body>

</html>
