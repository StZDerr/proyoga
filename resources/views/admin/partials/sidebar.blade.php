<!-- Боковая навигация -->
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
            <a href=".">
                <img src="{{ asset('images/logo/logoYOGAwhite.svg') }}" class="navbar-brand-image">
                ИстокиЯ
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
                <div class="btn-list">
                    <a href="#" class="btn" target="_blank" rel="noopener">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <img src="{{ asset('images/favicon-32x32-1.png') }}" alt="favicon">
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name ?? 'Админ' }}</div>
                        <div class="mt-1 small text-muted">
                            Администратор
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Профиль</a>
                    <a href="#" class="dropdown-item">Настройки</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Выйти</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Главная
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#sidebar-content" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebar-content">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12l0 9" />
                                <path d="M12 12l-8 -4.5" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Контент
                        </span>
                    </a>
                    <div class="collapse" id="sidebar-content">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.personal.index') }}">
                                    Преподователи
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.gallery.index') }}">
                                    Галерея
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.questions.index') }}">
                                    Вопросы на странице welcome
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.promotions.index') }}">
                                    Акции
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.stories.index') }}">
                                    Сторис
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Пользователи
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#sidebar-directions" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebar-directions">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 12l2 2l4 -4" />
                                <path d="M21 12c-1 0 -3 0 -3 3s2 3 3 3s3 0 3 -3s-2 -3 -3 -3" />
                                <path d="M5 7h14a4 4 0 0 1 0 8h-1" />
                                <path d="M6 19h4" />
                                <path d="M5 7v12" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Направления
                        </span>
                    </a>
                    <div class="collapse" id="sidebar-directions">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.main-categories.index') }}">
                                    Категории Направлений
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.sub-categories.index') }}">
                                    ПодКатегории Направлений
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.sub-sub-categories.index') }}">
                                    ПодПодКатегории Направлений
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.sub-sub-category-faqs.index') }}">
                                    Вопросы-ответы
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#sidebar-tests" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebar-tests">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 12l2 2l4 -4" />
                                <path d="M21 12c-1 0 -3 0 -3 3s2 3 3 3s3 0 3 -3s-2 -3 -3 -3" />
                                <path d="M5 7h14a4 4 0 0 1 0 8h-1" />
                                <path d="M6 19h4" />
                                <path d="M5 7v12" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Тесты
                        </span>
                    </a>
                    <div class="collapse" id="sidebar-tests">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.test.submissions') }}">
                                    Результаты тестов
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.test.questions') }}">
                                    Управление вопросами
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#sidebar-price" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebar-price">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                <path d="M12 3v3m0 12v3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Прайс-лист
                        </span>
                    </a>
                    <div class="collapse" id="sidebar-price">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.price-categories.index') }}">
                                    Прайс-лист (Категории)
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.price-tables.index') }}">
                                    Прайс-лист (Таблицы)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.price-items.index') }}">
                                    Прайс-лист (Элементы)
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pages.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Страницы
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#sidebar-indexing" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebar-indexing">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- 🧠 Иконка SEO / индексации -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-seo"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 19h18" />
                                <path d="M4 9h4v7h-4z" />
                                <path d="M12 9a3 3 0 1 1 0 6a3 3 0 0 1 0 -6z" />
                                <path d="M20 9h-3a1 1 0 0 0 -1 1v5a1 1 0 0 0 1 1h3" />
                                <path d="M17 12h2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Индексация
                        </span>
                    </a>
                    <div class="collapse" id="sidebar-indexing">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="{{ route('admin.indexing.index') }}">
                                    Индексация сайта
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.companies.index') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                                <path
                                    d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.501.501 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89L8 0ZM3.777 3h8.447L8 1 3.777 3ZM2 6v7h1V6H2Zm2 0v7h2.5V6H4Zm3.5 0v7h1V6h-1Zm2 0v7H12V6H9.5ZM13 6v7h1V6h-1Zm2-1V4H1v1h14Zm-.39 9H1.39l-.25 1h13.72l-.25-1Z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Tapline
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
