@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Таблицы прайса</h2>
        <a href="{{ route('admin.price-tables.create') }}" class="btn btn-primary mb-3">Добавить таблицу</a>

        @include('admin.partials.success')

        {{-- Форма фильтрации по категории --}}
        <form method="GET" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-auto">
                    <label for="categoryFilter" class="form-label mb-1">Категория</label>
                    <select id="categoryFilter" name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Все категории</option>
                        @foreach ($categoriesList as $cat)
                            <option value="{{ $cat->id }}" @if ((string) ($currentCategory ?? '') === (string) $cat->id) selected @endif>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Скрытые поля, чтобы не терять сортировку при фильтрации --}}
                <input type="hidden" name="sort" value="{{ $currentSort ?? 'sort_order' }}">
                <input type="hidden" name="dir" value="{{ $currentDir ?? 'asc' }}">

                <div class="col-auto">
                    <a href="{{ route('admin.price-tables.index') }}" class="btn btn-outline-secondary">Сброс</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название таблицы</th>
                    <th>
                        @php
                            $dirToggle =
                                ($currentSort ?? '') === 'category' && ($currentDir ?? '') === 'asc' ? 'desc' : 'asc';
                            $urlForCategorySort = request()->fullUrlWithQuery([
                                'sort' => 'category',
                                'dir' => $dirToggle,
                            ]);
                        @endphp

                        <a href="{{ $urlForCategorySort }}" class="text-decoration-none">
                            Категория
                            @if (($currentSort ?? '') === 'category')
                                @if (($currentDir ?? '') === 'asc')
                                    &uarr;
                                @else
                                    &darr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>Порядок сортировки</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $table)
                    <tr>
                        <td>{{ $table->id }}</td>
                        <td>{{ $table->title }}</td>
                        <td>{{ $table->category->name ?? '-' }}</td>
                        <td>{{ $table->sort_order }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.price-tables.move-up', $table) }}"
                                style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary"
                                    @if ($loop->first) disabled @endif title="Поднять">↑</button>
                            </form>
                            <form method="POST" action="{{ route('admin.price-tables.move-down', $table) }}"
                                style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary"
                                    @if ($loop->last) disabled @endif title="Опустить">↓</button>
                            </form>
                            <a href="{{ route('admin.price-tables.edit', $table) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.price-tables.destroy', $table) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Нет таблиц</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
