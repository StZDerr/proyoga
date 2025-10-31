<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ панель') - ПроЙога</title>
    @include('partials.favicon')

    {{-- Tabler CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">

    {{-- Font Awesome icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite('resources/css/admin/app.css')
    @stack('styles')
</head>

<body>
    <div class="page">
        @include('admin.partials.sidebar')

        <!-- Основной контент -->
        <div class="page-wrapper">
            @yield('content')

            <!-- Футер -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary">Документация</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary">Лицензия</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary" target="_blank" rel="noopener">Исходный
                                        код</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Авторские права © {{ date('Y') }}
                                    <a href="#" class="link-secondary">ПроЙога</a>.
                                    Все права защищены.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Tabler JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    @vite('resources/js/admin/app.js')
    @stack('scripts')
</body>

</html>
