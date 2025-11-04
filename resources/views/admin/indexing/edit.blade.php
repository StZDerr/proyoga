@extends('admin.layouts.app')

@section('title', 'Редактировать: ' . $indexing->title)

@section('content')
    @include('admin.partials.success')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('admin.indexing.index') }}">Управление индексацией</a>
                    </div>
                    <h2 class="page-title">
                        Редактировать страницу
                    </h2>
                    <div class="page-subtitle">
                        <code>{{ $indexing->url }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-lg-5">
                    <form action="{{ route('admin.indexing.update', $indexing) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Основная информация</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">URL страницы</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                        name="url" value="{{ old('url', $indexing->url) }}" placeholder="/example-page"
                                        required>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Начинайте с символа /</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Заголовок страницы</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title', $indexing->title) }}"
                                        placeholder="Название страницы" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Описание страницы</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                        placeholder="Краткое описание содержимого страницы">{{ old('description', $indexing->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Это описание будет использоваться в sitemap</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">SEO настройки</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Приоритет</label>
                                            <select class="form-select @error('priority') is-invalid @enderror"
                                                name="priority" required>
                                                <option value="">Выберите приоритет</option>
                                                <option value="1.0"
                                                    {{ old('priority', $indexing->priority) == '1.0' ? 'selected' : '' }}>
                                                    1.0 - Очень высокий (главная)</option>
                                                <option value="0.9"
                                                    {{ old('priority', $indexing->priority) == '0.9' ? 'selected' : '' }}>
                                                    0.9 - Высокий (важные разделы)</option>
                                                <option value="0.8"
                                                    {{ old('priority', $indexing->priority) == '0.8' ? 'selected' : '' }}>
                                                    0.8 - Средне-высокий</option>
                                                <option value="0.7"
                                                    {{ old('priority', $indexing->priority) == '0.7' ? 'selected' : '' }}>
                                                    0.7 - Средний</option>
                                                <option value="0.6"
                                                    {{ old('priority', $indexing->priority) == '0.6' ? 'selected' : '' }}>
                                                    0.6 - Средне-низкий</option>
                                                <option value="0.5"
                                                    {{ old('priority', $indexing->priority) == '0.5' ? 'selected' : '' }}>
                                                    0.5 - Низкий</option>
                                                <option value="0.3"
                                                    {{ old('priority', $indexing->priority) == '0.3' ? 'selected' : '' }}>
                                                    0.3 - Очень низкий</option>
                                            </select>
                                            @error('priority')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Частота обновления</label>
                                            <select class="form-select @error('changefreq') is-invalid @enderror"
                                                name="changefreq" required>
                                                <option value="">Выберите частоту</option>
                                                <option value="always"
                                                    {{ old('changefreq', $indexing->changefreq) == 'always' ? 'selected' : '' }}>
                                                    Всегда</option>
                                                <option value="hourly"
                                                    {{ old('changefreq', $indexing->changefreq) == 'hourly' ? 'selected' : '' }}>
                                                    Каждый час</option>
                                                <option value="daily"
                                                    {{ old('changefreq', $indexing->changefreq) == 'daily' ? 'selected' : '' }}>
                                                    Ежедневно</option>
                                                <option value="weekly"
                                                    {{ old('changefreq', $indexing->changefreq) == 'weekly' ? 'selected' : '' }}>
                                                    Еженедельно</option>
                                                <option value="monthly"
                                                    {{ old('changefreq', $indexing->changefreq) == 'monthly' ? 'selected' : '' }}>
                                                    Ежемесячно</option>
                                                <option value="yearly"
                                                    {{ old('changefreq', $indexing->changefreq) == 'yearly' ? 'selected' : '' }}>
                                                    Ежегодно</option>
                                                <option value="never"
                                                    {{ old('changefreq', $indexing->changefreq) == 'never' ? 'selected' : '' }}>
                                                    Никогда</option>
                                            </select>
                                            @error('changefreq')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_indexed" value="1"
                                            {{ old('is_indexed', $indexing->is_indexed) ? 'checked' : '' }}>
                                        <span class="form-check-label">Включить в индексацию</span>
                                    </label>
                                    <small class="form-hint">Если отключено, страница не будет добавлена в sitemap</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Заметки администратора</label>
                                    <textarea class="form-control" name="notes" rows="3" placeholder="Дополнительные заметки для себя...">{{ old('notes', $indexing->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="{{ route('admin.indexing.show', $indexing) }}" class="btn">
                                    Отменить
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Сохранить изменения
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-7">
                    <!-- Текущие настройки -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Текущие настройки</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="text-muted">Статус индексации</div>
                                @if ($indexing->is_indexed)
                                    <span class="badge bg-success">Индексируется</span>
                                @else
                                    <span class="badge bg-danger">Скрыта</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <div class="text-muted">Приоритет</div>
                                <span class="badge bg-info">{{ $indexing->priority }}</span>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted">Частота обновления</div>
                                <span class="badge bg-secondary">{{ $indexing->changefreq }}</span>
                            </div>

                            <div class="mb-3">
                                <div class="text-muted">Последнее изменение</div>
                                <div class="small">
                                    @if ($indexing->last_modified)
                                        {{ $indexing->last_modified->format('d.m.Y H:i') }}
                                    @else
                                        {{ $indexing->updated_at->format('d.m.Y H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Справка -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Справка</h3>
                        </div>
                        <div class="card-body">
                            <h4>Приоритет страницы:</h4>
                            <ul class="small">
                                <li><strong>1.0</strong> - Главная страница</li>
                                <li><strong>0.9</strong> - Важные разделы</li>
                                <li><strong>0.8</strong> - Основные страницы</li>
                                <li><strong>0.5-0.7</strong> - Обычные страницы</li>
                                <li><strong>0.3</strong> - Служебные страницы</li>
                            </ul>

                            <h4 class="mt-3">Частота обновления:</h4>
                            <ul class="small">
                                <li><strong>Weekly</strong> - Главная страница</li>
                                <li><strong>Monthly</strong> - Обычные страницы</li>
                                <li><strong>Yearly</strong> - Статичные страницы</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Дополнительные действия -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Дополнительные действия</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('admin.indexing.show', $indexing) }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-eye me-2"></i>
                                    Просмотреть страницу
                                </a>
                                <a href="{{ url($indexing->url) }}" target="_blank"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Открыть на сайте
                                </a>
                                <a href="{{ route('admin.indexing.toggle-page', $indexing) }}"
                                    class="list-group-item list-group-item-action">
                                    <i class="fas fa-toggle-{{ $indexing->is_indexed ? 'on' : 'off' }} me-2"></i>
                                    {{ $indexing->is_indexed ? 'Отключить' : 'Включить' }} индексацию
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
