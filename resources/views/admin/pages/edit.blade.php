@extends('admin.layouts.app')

@section('title', 'Редактирование страницы')
@section('header', 'Редактирование страницы: ' . $page->title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Основная информация</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug страницы *</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $page->slug) }}" required
                                placeholder="home, about, services...">
                            <div class="form-text">URL адрес страницы (только латинские буквы, цифры, дефисы)</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок страницы *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $page->title) }}" required
                                placeholder="Заголовок для тега <title>">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание страницы</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Описание для meta description">{{ old('description', $page->description) }}</textarea>
                            <div class="form-text">Рекомендуемая длина: 150-160 символов</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label">Ключевые слова</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                id="keywords" name="keywords" value="{{ old('keywords', $page->keywords) }}"
                                placeholder="ключевое слово 1, ключевое слово 2, ...">
                            <div class="form-text">Разделяйте запятыми</div>
                            @error('keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Активная страница
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Контент страницы</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="content" class="form-label">Основной контент</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                placeholder="HTML контент страницы...">{{ old('content', $page->content) }}</textarea>
                            <div class="form-text">Можно использовать HTML теги</div>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO настройки</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="og_title" class="form-label">Open Graph заголовок</label>
                            <input type="text" class="form-control" id="og_title" name="og_title"
                                value="{{ old('og_title', $page->seo_data['og_title'] ?? '') }}"
                                placeholder="Заголовок для социальных сетей">
                            <div class="form-text">Если не заполнено, будет использован основной заголовок</div>
                        </div>

                        <div class="mb-3">
                            <label for="og_description" class="form-label">Open Graph описание</label>
                            <textarea class="form-control" id="og_description" name="og_description" rows="2"
                                placeholder="Описание для социальных сетей">{{ old('og_description', $page->seo_data['og_description'] ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label">Open Graph изображение</label>
                            <input type="text" class="form-control" id="og_image" name="og_image"
                                value="{{ old('og_image', $page->seo_data['og_image'] ?? '') }}"
                                placeholder="/images/og-image.jpg">
                            <div class="form-text">Путь к изображению для социальных сетей</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Сохранить изменения
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Информация о странице</h6>
                </div>
                <div class="card-body">
                    <p><strong>Создана:</strong> {{ $page->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Обновлена:</strong> {{ $page->updated_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Статус:</strong>
                        @if ($page->is_active)
                            <span class="badge bg-success">Активна</span>
                        @else
                            <span class="badge bg-secondary">Неактивна</span>
                        @endif
                    </p>
                    @if ($page->is_active)
                        <a href="{{ url('/' . ($page->slug === 'home' ? '' : $page->slug)) }}" target="_blank"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>Посмотреть на сайте
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
