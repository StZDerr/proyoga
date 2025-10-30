@extends('admin.layouts.app')

@section('title', 'Панель управления')

@section('content')
    <!-- Заголовок страницы -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Обзор
                    </div>
                    <h2 class="page-title">
                        Панель управления
                    </h2>
                </div>
                <!-- Действия в заголовке -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="#" class="btn">
                                Новое занятие
                            </a>
                        </span>
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Создать отчет
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-report" aria-label="Создать отчет">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Содержимое страницы -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Статистические карточки -->
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Активных занятий</div>
                                <div class="ms-auto lh-1">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Сегодня</a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item active" href="#">Сегодня</a>
                                            <a class="dropdown-item" href="#">Неделя</a>
                                            <a class="dropdown-item" href="#">Месяц</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h1 mb-3">12</div>
                            <div class="d-flex mb-2">
                                <div>Завершенных занятий</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        8%
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 17l6 -6l4 4l8 -8" />
                                            <path d="M14 7l7 0l0 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 75%" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                                    <span class="visually-hidden">75% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Учеников</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-0 me-2">147</div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        12%
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 17l6 -6l4 4l8 -8" />
                                            <path d="M14 7l7 0l0 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="chart-revenue-bg" class="chart-sm"></div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Доходы</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">₽89,400</div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        6%
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 17l6 -6l4 4l8 -8" />
                                            <path d="M14 7l7 0l0 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div>За этот месяц</div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 64%" role="progressbar"
                                    aria-valuenow="64" aria-valuemin="0" aria-valuemax="100" aria-label="64% Complete">
                                    <span class="visually-hidden">64% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Преподавателей</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">8</div>
                                <div class="me-auto">
                                    <span class="text-red d-inline-flex align-items-center lh-1">
                                        -2%
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 7l6 6l4 -4l8 8" />
                                            <path d="M17 17l7 0l0 -7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div>Активных в этом месяце</div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 100%" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                    aria-label="100% Complete">
                                    <span class="visually-hidden">100% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Основные блоки контента -->
            <div class="row row-deck row-cards">
                <!-- График активности -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Активность занятий</h3>
                        </div>
                        <div class="card-body">
                            <div id="chart-mentions" class="chart-lg"></div>
                        </div>
                    </div>
                </div>

                <!-- Список последних занятий -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Последние занятия</h3>
                        </div>
                        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                            <div class="divide-y">
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar">АН</span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong>Анна Николаева</strong> провела
                                                <strong>Хатха-йога</strong>
                                            </div>
                                            <div class="text-muted">15 учеников • 1ч 30м назад</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-success"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar"
                                                style="background-image: url(./static/avatars/002f.jpg)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong>Мария Петрова</strong> провела
                                                <strong>Аштанга-йога</strong>
                                            </div>
                                            <div class="text-muted">12 учеников • 2ч назад</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-success"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar">ЕС</span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong>Елена Сидорова</strong> провела <strong>Йога для
                                                    начинающих</strong>
                                            </div>
                                            <div class="text-muted">8 учеников • 3ч назад</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-success"></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar"
                                                style="background-image: url(./static/avatars/003f.jpg)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                                <strong>Дарья Козлова</strong> провела
                                                <strong>Виньяса-флоу</strong>
                                            </div>
                                            <div class="text-muted">20 учеников • 4ч назад</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="badge bg-success"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Календар расписания -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Расписание на сегодня</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot status-dot-animated bg-red d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Хатха-йога</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Анна Николаева • Зал 1
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                09:00
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot status-dot-animated bg-green d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Йога для
                                                начинающих</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Елена Сидорова • Зал 2
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                11:30
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Аштанга-йога</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Мария Петрова • Зал 1
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                18:00
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="status-dot d-block"></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Виньяса-флоу</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Дарья Козлова • Зал 2
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                20:00
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
