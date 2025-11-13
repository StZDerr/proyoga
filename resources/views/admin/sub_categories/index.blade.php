@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Подкатегории</h2>
        @include('admin.partials.success')

        <div class="row mb-3">
            <div class="col-md-8">
                <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary">Добавить подкатегорию</a>
            </div>
        </div>

        {{-- Форма фильтров --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.sub-categories.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="main_category_id" class="form-label">Главная категория</label>
                        <select name="main_category_id" id="main_category_id" class="form-select">
                            <option value="">Все категории</option>
                            @foreach ($mainCategories as $mainCat)
                                <option value="{{ $mainCat->id }}"
                                    {{ request('main_category_id') == $mainCat->id ? 'selected' : '' }}>
                                    {{ $mainCat->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Применить
                        </button>
                        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Сбросить
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Главная категория</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subCategories as $sub)
                    <tr>
                        <td>{{ $sub->mainCategory->title }}</td>
                        <td>{{ $sub->title }}</td>
                        <td>{{ $sub->description }}</td>
                        <td>
                            @if ($sub->image)
                                <img src="{{ asset('storage/' . $sub->image) }}" width="80" alt="">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.sub-categories.edit', $sub) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.sub-categories.destroy', $sub) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить подкатегорию?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            @if (request()->hasAny(['main_category_id']))
                                Подкатегорий с выбранными фильтрами не найдено
                            @else
                                Нет подкатегорий
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
