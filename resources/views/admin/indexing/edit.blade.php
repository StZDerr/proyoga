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
                    <h2 class="page-title">Редактировать страницу</h2>
                    <div class="page-subtitle">
                        <code>{{ $indexing->url }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Основная форма -->
            <form action="{{ route('admin.indexing.update', $indexing) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Основная информация</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">URL страницы</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" name="url"
                                value="{{ old('url', $indexing->url) }}" placeholder="/example-page" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Начинайте с символа /</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Заголовок страницы</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $indexing->title) }}" placeholder="Название страницы" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание страницы</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                placeholder="Краткое описание">{{ old('description', $indexing->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">Описание используется в sitemap</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Open Graph изображение</label>
                            @if (!empty($indexing->og_image))
                                <div class="mb-2">
                                    <div class="border rounded p-2" style="max-width:200px;">
                                        <img src="{{ asset($indexing->og_image) }}" class="img-fluid rounded"
                                            style="max-height:100px;" alt="Текущее изображение">
                                        <div class="text-muted small mt-1">Текущее изображение</div>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('og_image_file') is-invalid @enderror"
                                name="og_image_file" accept="image/*">
                            <div class="form-text">
                                Загрузите новое изображение (JPG, PNG, WEBP). Рекомендуемый размер: 1200x630px
                            </div>
                            @error('og_image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO настройки -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">SEO настройки</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Приоритет</label>
                                <select class="form-select @error('priority') is-invalid @enderror" name="priority"
                                    required>
                                    <option value="">Выберите приоритет</option>
                                    @foreach (['1.0', '0.9', '0.8', '0.7', '0.6', '0.5', '0.3'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('priority', $indexing->priority) == $p ? 'selected' : '' }}>
                                            {{ $p }}</option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Частота обновления</label>
                                <select class="form-select @error('changefreq') is-invalid @enderror" name="changefreq"
                                    required>
                                    <option value="">Выберите частоту</option>
                                    @foreach (['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'] as $freq)
                                        <option value="{{ $freq }}"
                                            {{ old('changefreq', $indexing->changefreq) == $freq ? 'selected' : '' }}>
                                            {{ ucfirst($freq) }}</option>
                                    @endforeach
                                </select>
                                @error('changefreq')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_indexed" value="1"
                                    {{ old('is_indexed', $indexing->is_indexed) ? 'checked' : '' }}>
                                <span class="form-check-label">Включить в индексацию</span>
                            </label>
                            <small class="form-hint">Если отключено, страница не попадет в sitemap</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Заметки администратора</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Дополнительные заметки...">{{ old('notes', $indexing->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="card mb-3">
                    <div class="card-body text-end">
                        <a href="{{ route('admin.indexing.show', $indexing) }}" class="btn btn-secondary">Отменить</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Сохранить
                            изменения</button>
                    </div>
                </div>
            </form>

            <!-- Текущие настройки -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Текущие настройки</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted">Статус индексации</div>
                        <span class="badge {{ $indexing->is_indexed ? 'bg-success' : 'bg-danger' }}">
                            {{ $indexing->is_indexed ? 'Индексируется' : 'Скрыта' }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted">Приоритет</div>
                        <span class="badge bg-info">{{ $indexing->priority }}</span>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted">Частота обновления</div>
                        <span class="badge bg-secondary">{{ $indexing->changefreq }}</span>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted">Последнее изменение</div>
                        <div class="small">
                            {{ $indexing->last_modified ? $indexing->last_modified->format('d.m.Y H:i') : $indexing->updated_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Справка -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Справка</h3>
                </div>
                <div class="card-body">
                    <h4>Приоритет страницы:</h4>
                    <ul class="small">
                        <li>1.0 - Главная страница</li>
                        <li>0.9 - Важные разделы</li>
                        <li>0.8 - Основные страницы</li>
                        <li>0.5-0.7 - Обычные страницы</li>
                        <li>0.3 - Служебные страницы</li>
                    </ul>
                    <h4 class="mt-3">Частота обновления:</h4>
                    <ul class="small">
                        <li>always/daily/weekly/monthly/yearly/never — в зависимости от типа страницы</li>
                    </ul>
                </div>
            </div>

            <!-- Дополнительные действия -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Дополнительные действия</h3>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.indexing.show', $indexing) }}"
                            class="list-group-item list-group-item-action">
                            <i class="fas fa-eye me-2"></i> Просмотреть страницу
                        </a>
                        <a href="{{ url($indexing->url) }}" target="_blank"
                            class="list-group-item list-group-item-action">
                            <i class="fas fa-external-link-alt me-2"></i> Открыть на сайте
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
@endsection
