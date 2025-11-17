@extends('admin.layouts.app')

@section('title', 'Добавить страницу для индексации')

@section('content')
    @include('admin.partials.success')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <a href="{{ route('admin.indexing.index') }}">Управление индексацией</a>
                    </div>
                    <h2 class="page-title">Добавить страницу</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <form action="{{ route('admin.indexing.store') }}" method="POST">
                        @csrf

                        <!-- Основная информация -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Основная информация</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">URL страницы</label>
                                    <input type="text" class="form-control @error('url') is-invalid @enderror"
                                        name="url" value="{{ old('url') }}" placeholder="/example-page" required>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Начинайте с символа /</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Заголовок страницы</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title') }}" placeholder="Название страницы" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Описание страницы</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                        placeholder="Краткое описание содержимого страницы">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Это описание будет использоваться в sitemap</small>
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
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Приоритет</label>
                                            <select class="form-select @error('priority') is-invalid @enderror"
                                                name="priority" required>
                                                <option value="">Выберите приоритет</option>
                                                <option value="1.0" {{ old('priority') == '1.0' ? 'selected' : '' }}>1.0
                                                    - Очень высокий (главная)</option>
                                                <option value="0.9" {{ old('priority') == '0.9' ? 'selected' : '' }}>0.9
                                                    - Высокий (важные разделы)</option>
                                                <option value="0.8" {{ old('priority') == '0.8' ? 'selected' : '' }}>0.8
                                                    - Средне-высокий</option>
                                                <option value="0.7" {{ old('priority') == '0.7' ? 'selected' : '' }}>0.7
                                                    - Средний</option>
                                                <option value="0.6" {{ old('priority') == '0.6' ? 'selected' : '' }}>0.6
                                                    - Средне-низкий</option>
                                                <option value="0.5" {{ old('priority') == '0.5' ? 'selected' : '' }}>0.5
                                                    - Низкий</option>
                                                <option value="0.3" {{ old('priority') == '0.3' ? 'selected' : '' }}>0.3
                                                    - Очень низкий</option>
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
                                                    {{ old('changefreq') == 'always' ? 'selected' : '' }}>Всегда</option>
                                                <option value="hourly"
                                                    {{ old('changefreq') == 'hourly' ? 'selected' : '' }}>Каждый час
                                                </option>
                                                <option value="daily"
                                                    {{ old('changefreq') == 'daily' ? 'selected' : '' }}>Ежедневно</option>
                                                <option value="weekly"
                                                    {{ old('changefreq') == 'weekly' ? 'selected' : '' }}>Еженедельно
                                                </option>
                                                <option value="monthly"
                                                    {{ old('changefreq') == 'monthly' ? 'selected' : '' }}>Ежемесячно
                                                </option>
                                                <option value="yearly"
                                                    {{ old('changefreq') == 'yearly' ? 'selected' : '' }}>Ежегодно</option>
                                                <option value="never"
                                                    {{ old('changefreq') == 'never' ? 'selected' : '' }}>Никогда</option>
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
                                            {{ old('is_indexed', true) ? 'checked' : '' }}>
                                        <span class="form-check-label">Включить в индексацию</span>
                                    </label>
                                    <small class="form-hint">Если отключено, страница не будет добавлена в sitemap</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Заметки администратора</label>
                                    <textarea class="form-control" name="notes" rows="3" placeholder="Дополнительные заметки для себя...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Справка -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Справка</h3>
                            </div>
                            <div class="card-body">
                                <h4>Рекомендации по приоритету:</h4>
                                <ul class="small">
                                    <li><strong>1.0</strong> - Главная страница сайта</li>
                                    <li><strong>0.9</strong> - Важные разделы (о нас, услуги)</li>
                                    <li><strong>0.8</strong> - Основные страницы контента</li>
                                    <li><strong>0.5-0.7</strong> - Обычные страницы</li>
                                    <li><strong>0.3</strong> - Служебные страницы</li>
                                </ul>

                                <h4 class="mt-3">Частота обновления:</h4>
                                <ul class="small">
                                    <li><strong>Always/Hourly</strong> - Динамичный контент</li>
                                    <li><strong>Daily</strong> - Новости, блог</li>
                                    <li><strong>Weekly</strong> - Главная страница</li>
                                    <li><strong>Monthly</strong> - Обычные страницы</li>
                                    <li><strong>Yearly</strong> - Статичные страницы</li>
                                    <li><strong>Never</strong> - Архивные страницы</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Примеры URL -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Примеры URL</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-selectgroup">
                                    <label class="form-selectgroup-item">
                                        <span class="form-selectgroup-label"><code>/about</code> - О нас</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <span class="form-selectgroup-label"><code>/services</code> - Услуги</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <span class="form-selectgroup-label"><code>/blog</code> - Блог</span>
                                    </label>
                                    <label class="form-selectgroup-item">
                                        <span class="form-selectgroup-label"><code>/gallery</code> - Галерея</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопки -->
                        <div class="card-footer bg-transparent mt-3">
                            <div class="btn-list justify-content-end">
                                <a href="{{ route('admin.indexing.index') }}" class="btn">Отменить</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Создать страницу
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
