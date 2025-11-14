@extends('admin.layouts.app')

@section('title', 'Просмотр страницы: ' . $indexing->title)

@section('content')
    @include('admin.partials.success')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('admin.indexing.index') }}">Управление индексацией</a>
                    </div>
                    <h2 class="page-title">{{ $indexing->title }}</h2>
                    <div class="page-subtitle">
                        <code>{{ $indexing->url }}</code>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.indexing.edit', $indexing) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Редактировать
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Информация о странице -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Информация о странице</h3>
                    <div class="card-actions">
                        @if ($indexing->is_indexed)
                            <span class="badge bg-success">Индексируется</span>
                        @else
                            <span class="badge bg-danger">Скрыта от индексации</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">URL страницы</label>
                            <div class="form-control-plaintext">
                                <code class="text-primary">{{ $indexing->url }}</code>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Статус индексации</label>
                            <div class="form-control-plaintext">
                                @if ($indexing->is_indexed)
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i> Индексируется</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i> Скрыта от
                                        индексации</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Заголовок страницы</label>
                                <div class="form-control-plaintext">{{ $indexing->title }}</div>
                            </div>
                        </div>
                        @if ($indexing->description)
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Описание</label>
                                    <div class="form-control-plaintext text-muted">{{ $indexing->description }}</div>
                                </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Приоритет</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $indexing->priority }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Частота обновления</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-secondary">{{ $indexing->changefreq }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($indexing->notes)
                        <div class="mb-3">
                            <label class="form-label">Заметки администратора</label>
                            <div class="form-control-plaintext text-muted">{{ $indexing->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">SEO информация</h3>
                </div>

            </div>

            <!-- Действия -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Действия</h3>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.indexing.edit', $indexing) }}"
                            class="list-group-item list-group-item-action">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar"><i class="fas fa-edit"></i></span>
                                </div>
                                <div class="col text-truncate">
                                    <strong>Редактировать</strong>
                                    <div class="text-muted">Изменить настройки страницы</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.indexing.toggle-page', $indexing) }}"
                            class="list-group-item list-group-item-action">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar"><i
                                            class="fas fa-toggle-{{ $indexing->is_indexed ? 'on' : 'off' }}"></i></span>
                                </div>
                                <div class="col text-truncate">
                                    <strong>{{ $indexing->is_indexed ? 'Отключить' : 'Включить' }} индексацию</strong>
                                    <div class="text-muted">Переключить статус</div>
                                </div>
                            </div>
                        </a>

                        @if ($indexing->url !== '/')
                            <form action="{{ route('admin.indexing.destroy', $indexing) }}" method="POST"
                                onsubmit="return confirm('Удалить страницу из индексации?')"
                                class="list-group-item list-group-item-action p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-3 text-danger w-100 text-start">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-danger text-white avatar"><i class="fas fa-trash"></i></span>
                                        </div>
                                        <div class="col text-truncate">
                                            <strong>Удалить</strong>
                                            <div class="text-muted">Удалить из индексации</div>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Информация о датах -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Информация</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted">Создана</div>
                            <div class="font-weight-medium">{{ $indexing->created_at->format('d.m.Y') }}</div>
                            <div class="small text-muted">{{ $indexing->created_at->format('H:i') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted">Обновлена</div>
                            <div class="font-weight-medium">{{ $indexing->updated_at->format('d.m.Y') }}</div>
                            <div class="small text-muted">{{ $indexing->updated_at->format('H:i') }}</div>
                        </div>
                    </div>

                    @if ($indexing->last_modified)
                        <div class="mb-3">
                            <div class="text-muted">Последнее изменение</div>
                            <div class="font-weight-medium">{{ $indexing->last_modified->format('d.m.Y H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Проверка URL -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Проверка URL</h3>
                </div>
                <div class="card-body">
                    <a href="{{ url($indexing->url) }}" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="fas fa-external-link-alt me-1"></i> Открыть страницу
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
