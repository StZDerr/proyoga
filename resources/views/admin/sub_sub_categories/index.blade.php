@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Подподкатегории</h2>

        @include('admin.partials.success')

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.sub-sub-categories.create') }}" class="btn btn-primary">Добавить подподкатегорию</a>
            </div>
        </div>

        {{-- Форма фильтров --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.sub-sub-categories.index') }}" class="row g-3" id="filterForm">
                    <div class="col-md-4">
                        <label for="main_category_id" class="form-label">Главная категория</label>
                        <select name="main_category_id" id="main_category_id" class="form-select">
                            <option value="">Все главные категории</option>
                            @foreach ($mainCategories as $mainCat)
                                <option value="{{ $mainCat->id }}"
                                    {{ request('main_category_id') == $mainCat->id ? 'selected' : '' }}>
                                    {{ $mainCat->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="sub_category_id" class="form-label">Подкатегория</label>
                        <select name="sub_category_id" id="sub_category_id" class="form-select">
                            <option value="">Все подкатегории</option>
                            @foreach ($subCategories as $subCat)
                                <option value="{{ $subCat->id }}" data-main-category="{{ $subCat->main_category_id }}"
                                    {{ request('sub_category_id') == $subCat->id ? 'selected' : '' }}>
                                    {{ $subCat->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Применить
                        </button>
                        <a href="{{ route('admin.sub-sub-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Сбросить
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Главная категория</th>
                    <th>Подкатегория</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>О программе</th>
                    <th>Преимущества</th>
                    <th>Изображение</th>
                    <th>Сколько фотографий</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subSubCategories as $subSub)
                    <tr>
                        <td>{{ $subSub->id }}</td>
                        <td>
                            @if ($subSub->subCategory && $subSub->subCategory->mainCategory)
                                {{ $subSub->subCategory->mainCategory->title }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if ($subSub->subCategory)
                                {{ $subSub->subCategory->title }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $subSub->title }}</td>
                        <td>{{ Str::limit($subSub->description, 50) }}</td>
                        <td>{{ Str::limit($subSub->about, 50) }}</td>
                        <td>
                            @php
                                $benefitGroups = $subSub->benefits ?? [];
                                $count = is_array($benefitGroups) ? count($benefitGroups) : 0;
                                $tooltipText = '';

                                if ($count > 0) {
                                    $texts = [];
                                    foreach ($benefitGroups as $group) {
                                        $title = e($group['title'] ?? 'Без названия');
                                        $benefitsList = e(implode(', ', $group['benefits'] ?? []));
                                        $texts[] = "<strong>{$title}:</strong> {$benefitsList}";
                                    }
                                    $tooltipText = implode('<br><br>', $texts);
                                }
                            @endphp

                            @if ($count > 0)
                                <span data-bs-toggle="tooltip" data-bs-html="true" title="{!! $tooltipText !!}"
                                    class="badge bg-info text-dark px-3 py-2" style="cursor: help; display: inline-block;">
                                    {{ $count }}
                                </span>
                            @else
                                <span class="text-muted">Нет преимуществ</span>
                            @endif
                        </td>
                        <td>
                            @if ($subSub->image)
                                <img src="{{ asset('storage/' . $subSub->image) }}" alt="{{ $subSub->title }}"
                                    width="100">
                            @endif
                        </td>
                        <td>{{ $subSub->photos->count() }}</td>
                        <td>
                            <a href="{{ route('admin.sub-sub-categories.edit', $subSub) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.sub-sub-categories.destroy', $subSub) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить подподкатегорию?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            @if (request()->hasAny(['main_category_id', 'sub_category_id']))
                                Подподкатегорий с выбранными фильтрами не найдено
                            @else
                                Подподкатегорий нет
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- JavaScript для динамической фильтрации подкатегорий --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainCategorySelect = document.getElementById('main_category_id');
            const subCategorySelect = document.getElementById('sub_category_id');
            const allSubCategories = Array.from(subCategorySelect.options);

            function filterSubCategories() {
                const selectedMainCategory = mainCategorySelect.value;

                // Очищаем select подкатегорий
                subCategorySelect.innerHTML = '<option value="">Все подкатегории</option>';

                // Добавляем только те подкатегории, которые относятся к выбранной главной категории
                allSubCategories.forEach(option => {
                    if (option.value === '') return; // Пропускаем пустой option

                    const optionMainCategory = option.getAttribute('data-main-category');

                    if (!selectedMainCategory || optionMainCategory === selectedMainCategory) {
                        subCategorySelect.appendChild(option.cloneNode(true));
                    }
                });
            }

            // Применяем фильтр при изменении главной категории
            mainCategorySelect.addEventListener('change', filterSubCategories);

            // Применяем фильтр при загрузке страницы (если уже выбрана главная категория)
            if (mainCategorySelect.value) {
                filterSubCategories();
            }
        });
    </script>
@endsection
