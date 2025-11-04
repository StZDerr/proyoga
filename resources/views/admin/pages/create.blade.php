@extends('admin.layouts.app')

@section('title', 'Создание страницы')
@section('header', 'Создание новой страницы')

@section('content')
    @include('admin.partials.success')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Основная информация</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug страницы *</label>

                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" autocomplete="off" required
                                placeholder="home, about, direction/ioga-i-smeznye-praktiki">

                            <div class="form-text">URL адрес страницы (без начального слеша; латинские буквы, цифры,
                                дефисы). Подсказки ниже фильтруются по вводу.</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Контейнер подсказок -->
                            <div id="slug-suggestions" class="list-group mt-2"
                                style="max-height:240px; overflow:auto; display:none;"></div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок страницы *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required
                                placeholder="Заголовок для тега <title>">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание страницы</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" placeholder="Описание для meta description">{{ old('description') }}</textarea>
                            <div class="form-text">Рекомендуемая длина: 150-160 символов</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label">Ключевые слова</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                id="keywords" name="keywords" value="{{ old('keywords') }}"
                                placeholder="ключевое слово 1, ключевое слово 2, ...">
                            <div class="form-text">Разделяйте запятыми</div>
                            @error('keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
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
                                placeholder="HTML контент страницы...">{{ old('content') }}</textarea>
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
                                value="{{ old('og_title') }}" placeholder="Заголовок для социальных сетей">
                            <div class="form-text">Если не заполнено, будет использован основной заголовок</div>
                        </div>

                        <div class="mb-3">
                            <label for="og_description" class="form-label">Open Graph описание</label>
                            <textarea class="form-control" id="og_description" name="og_description" rows="2"
                                placeholder="Описание для социальных сетей">{{ old('og_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="og_image_file" class="form-label">Open Graph изображение</label>
                            <input type="file" class="form-control @error('og_image_file') is-invalid @enderror"
                                id="og_image_file" name="og_image_file" accept="image/*">
                            <div class="form-text">
                                Загрузите изображение для социальных сетей (JPG, PNG, WEBP).
                                Рекомендуемый размер: 1200x630px
                            </div>
                            @error('og_image_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Создать страницу
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Список подсказок из сервера (передайте $suggested в контроллере)
            const suggested = @json($suggested ?? []);
            const input = document.getElementById('slug');
            const box = document.getElementById('slug-suggestions');

            // Нормализующая функция (удаляет ведущие слэши и лишние пробелы)
            function normalize(val) {
                return val ? String(val).trim().replace(/^\/+/, '') : '';
            }

            // Рендер одного варианта в list-group
            function renderOption(value) {
                const a = document.createElement('button');
                a.type = 'button';
                a.className = 'list-group-item list-group-item-action';
                a.textContent = value;
                a.addEventListener('click', function() {
                    input.value = value;
                    hideBox();
                    input.focus();
                });
                return a;
            }

            // Показать подсказки (filtered array)
            function showSuggestions(list) {
                box.innerHTML = '';
                if (!list || list.length === 0) {
                    hideBox();
                    return;
                }
                list.forEach(v => box.appendChild(renderOption(v)));
                box.style.display = 'block';
            }

            function hideBox() {
                box.style.display = 'none';
            }

            // Фильтрация: по подстроке, нечувствительно к регистру
            function filterSuggestions(term) {
                if (!term) return suggested.slice(0, 40); // топ N
                const q = term.toLowerCase();
                return suggested.filter(s => s && s.toLowerCase().includes(q)).slice(0, 40);
            }

            // События
            input.addEventListener('input', function() {
                const val = normalize(this.value);
                if (!val) {
                    // при пустом поле всё ещё показываем топ-10
                    showSuggestions(filterSuggestions(''));
                    return;
                }
                showSuggestions(filterSuggestions(val));
            });

            input.addEventListener('focus', function() {
                // показать подсказки при фокусе
                const val = normalize(this.value);
                showSuggestions(filterSuggestions(val));
            });

            // Скрыть по клику вне поля
            document.addEventListener('click', function(e) {
                if (!box.contains(e.target) && e.target !== input) {
                    hideBox();
                }
            });

            // Нормализация перед submit: удаляем ведущие слэши и пробелы
            const form = input && input.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    input.value = normalize(input.value);
                });
            }

            // Инициализация: если список подсказок не пуст, подготовим скрытый список
            if (Array.isArray(suggested) && suggested.length > 0) {
                // опционально: отсортируем и уберём дубликаты
                const uniq = Array.from(new Set(suggested.map(s => normalize(s)).filter(Boolean)));
                // перезаписать переменную suggested (локально)
                // (не мутируем глобально, но можно)
            }
        });
    </script>
@endsection
