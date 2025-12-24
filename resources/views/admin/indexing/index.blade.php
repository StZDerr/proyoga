@extends('admin.layouts.app')

@section('title', 'Управление индексацией')

@section('content')
    @include('admin.partials.success')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Управление индексацией
                    </h2>
                    <div class="page-subtitle">
                        Настройка индексации сайта поисковыми системами
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.indexing.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fas fa-plus me-1"></i>
                            Добавить страницу
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Общие настройки -->
            <div class="row row-deck row-cards mb-3">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Общие настройки индексации</h3>
                            <div class="card-actions">
                                @if ($settings->global_indexing_enabled)
                                    <span class="badge bg-success">Индексация включена</span>
                                @else
                                    <span class="badge bg-danger">Индексация отключена</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.indexing.update-settings') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="global_indexing_enabled" value="1"
                                                    {{ $settings->global_indexing_enabled ? 'checked' : '' }}>
                                                <span class="form-check-label">Разрешить индексацию сайта</span>
                                            </label>
                                            <small class="form-hint">Глобальное включение/отключение индексации</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="sitemap_enabled"
                                                    value="1" {{ $settings->sitemap_enabled ? 'checked' : '' }}>
                                                <span class="form-check-label">Включить sitemap.xml</span>
                                            </label>
                                            <small class="form-hint">Автоматическая генерация карты сайта</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Содержимое robots.txt</label>
                                    <textarea class="form-control" name="robots_txt_content" rows="6" placeholder="User-agent: *">{{ $settings->robots_txt_content }}</textarea>
                                    <small class="form-hint">Правила для поисковых роботов</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Заметки администратора</label>
                                    <textarea class="form-control" name="notes" rows="3" placeholder="Заметки для себя...">{{ $settings->notes }}</textarea>
                                </div>

                                <div class="card-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Сохранить настройки
                                    </button>
                                    <a href="{{ route('admin.indexing.toggle') }}" class="btn btn-warning">
                                        <i
                                            class="fas fa-toggle-{{ $settings->global_indexing_enabled ? 'on' : 'off' }} me-1"></i>
                                        {{ $settings->global_indexing_enabled ? 'Отключить' : 'Включить' }} индексацию
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Быстрые действия -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Быстрые действия</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('admin.indexing.generate-sitemap') }}"
                                    class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-success text-white avatar">
                                                <i class="fas fa-sitemap"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Обновить sitemap.xml</strong>
                                            <div class="text-muted">Пересоздать карту сайта</div>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ route('admin.indexing.initialize') }}"
                                    class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-info text-white avatar">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Создать дефолтные страницы</strong>
                                            <div class="text-muted">Добавить основные страницы</div>
                                        </div>
                                    </div>
                                </a>

                                {{-- <a href="{{ route('admin.indexing.sync-dynamic') }}"
                                    class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-warning text-white avatar">
                                                <i class="fas fa-sync"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Синхронизировать направления</strong>
                                            <div class="text-muted">Добавить страницы направлений йоги</div>
                                        </div>
                                    </div>
                                </a> --}}

                                <a href="{{ route('admin.indexing.cleanup') }}"
                                    class="list-group-item list-group-item-action"
                                    onclick="return confirm('Удалить все устаревшие страницы?')">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-danger text-white avatar">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Очистить устаревшие</strong>
                                            <div class="text-muted">Удалить несуществующие страницы</div>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ url('/robots.txt') }}" target="_blank"
                                    class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-secondary text-white avatar">
                                                <i class="fas fa-robot"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Просмотреть robots.txt</strong>
                                            <div class="text-muted">Открыть в новой вкладке</div>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ url('/sitemap.xml') }}" target="_blank"
                                    class="list-group-item list-group-item-action">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-primary text-white avatar">
                                                <i class="fas fa-map"></i>
                                            </span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Просмотреть sitemap.xml</strong>
                                            <div class="text-muted">Открыть в новой вкладке</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Статистика -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Статистика страниц</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h1 text-success">{{ $pages->where('is_indexed', true)->count() }}
                                        </div>
                                        <div class="text-muted">Индексируемых</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="h1 text-danger">{{ $pages->where('is_indexed', false)->count() }}
                                        </div>
                                        <div class="text-muted">Скрытых</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Список страниц -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Страницы для индексации</h3>
                </div>
                <div class="card-body">
                    @if ($pages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Заголовок</th>
                                        <th>Приоритет</th>
                                        <th>Частота</th>
                                        <th>Статус</th>
                                        <th>Обновлено</th>
                                        <th class="w-1">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $page)
                                        <tr>
                                            <td>
                                                <code class="small">{{ $page->url }}</code>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    {{ $page->title }}
                                                </div>
                                                @if ($page->description)
                                                    <div class="text-muted small">{{ Str::limit($page->description, 50) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $page->priority }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $page->changefreq }}</span>
                                            </td>
                                            <td>
                                                @if ($page->is_indexed)
                                                    <span class="badge bg-success">Индексируется</span>
                                                @else
                                                    <span class="badge bg-danger">Скрыта</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($page->last_modified)
                                                    <span
                                                        class="text-muted">{{ $page->last_modified->format('d.m.Y') }}</span>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.indexing.show', $page) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Просмотр">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.indexing.edit', $page) }}"
                                                        class="btn btn-sm btn-outline-success" title="Редактировать">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.indexing.toggle-page', $page) }}"
                                                        class="btn btn-sm btn-outline-warning"
                                                        title="Переключить индексацию">
                                                        <i
                                                            class="fas fa-toggle-{{ $page->is_indexed ? 'on' : 'off' }}"></i>
                                                    </a>
                                                    <form action="{{ route('admin.indexing.destroy', $page) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Удалить страницу из индексации?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Удалить">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty">
                            <div class="empty-img">
                                <img src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/img/illustrations/undraw_printing_invoices_5r4r.svg"
                                    height="128" alt="">
                            </div>
                            <p class="empty-title">Нет страниц для индексации</p>
                            <p class="empty-subtitle text-muted">
                                Добавьте страницы, которые должны индексироваться поисковыми системами
                            </p>
                            <div class="empty-action">
                                <a href="{{ route('admin.indexing.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Добавить первую страницу
                                </a>
                                <a href="{{ route('admin.indexing.initialize') }}" class="btn btn-outline-primary">
                                    Создать дефолтные страницы
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
