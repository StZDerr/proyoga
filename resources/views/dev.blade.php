<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')

    <div class="dev-page">
        <div class="dev-container">
            <img src="{{ asset('images/logo/IstikiiY.svg') }}" alt="Logo" class="dev-logo" />

            <h1 class="dev-title">Данный раздел находится в разработке</h1>
            <p class="dev-subtitle">Скоро здесь появятся новые возможности!</p>

            <a href="{{ route('welcome') }}" class="btn-home">
                Главная
            </a>

            <!-- Анимация движущихся блоков -->
            <div class="dev-animation">
                <div class="block block1"></div>
                <div class="block block2"></div>
                <div class="block block3"></div>
                <div class="block block4"></div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <style>
        /* Общий фон и центрирование */
        .dev-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(120deg, #f5f5f5, #e0f7fa);
            font-family: 'Montserrat', sans-serif;
            overflow: hidden;
            position: relative;
        }

        .dev-container {
            text-align: center;
            z-index: 2;
            position: relative;
        }

        /* Логотип */
        .dev-logo {
            width: 250px;
            max-width: 100%;
            height: auto;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        /* Заголовок и подзаголовок */
        .dev-title {
            font-size: clamp(2rem, 2vw + 1rem, 3rem);
            color: #123d4d;
            margin-bottom: 10px;
        }

        .dev-subtitle {
            font-size: clamp(1rem, 1vw + 0.5rem, 1.5rem);
            color: #1d7d6f;
            margin-bottom: 30px;
        }

        /* Кнопка "Главная" */
        .btn-home {
            display: inline-block;
            padding: 12px 30px;
            font-size: var(--font-size-text-desc-28px);
            font-weight: 600;
            color: white;
            background-color: #123d4d;
            border-radius: 1.8rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .btn-home:hover {
            background-color: white;
            color: #123d4d;
        }

        /* Пульс логотипа */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Анимация блоков */
        .dev-animation {
            pointer-events: none;
            /* теперь клики “проходят” сквозь блок */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .block {
            position: absolute;
            width: 30px;
            height: 30px;
            background: rgba(18, 61, 77, 0.3);
            border-radius: 5px;
            animation: move 6s linear infinite;
        }

        .block1 {
            top: 10%;
            left: 20%;
            animation-delay: 0s;
        }

        .block2 {
            top: 30%;
            left: 50%;
            animation-delay: 2s;
        }

        .block3 {
            top: 60%;
            left: 70%;
            animation-delay: 4s;
        }

        .block4 {
            top: 80%;
            left: 40%;
            animation-delay: 1s;
        }

        @keyframes move {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.7;
            }

            50% {
                transform: translate(200px, -150px) rotate(180deg);
                opacity: 0.4;
            }

            100% {
                transform: translate(-100px, 200px) rotate(360deg);
                opacity: 0.7;
            }
        }

        /* Адаптив */
        @media (max-width: 768px) {
            .dev-logo {
                width: 200px;
            }

            .dev-title {
                font-size: clamp(1.5rem, 2vw + 0.5rem, 2.5rem);
            }

            .dev-subtitle {
                font-size: clamp(0.9rem, 1vw + 0.3rem, 1.2rem);
            }

            .btn-home {
                width: 80%;
                padding: 12px 0;
            }
        }
    </style>
</body>

</html>
