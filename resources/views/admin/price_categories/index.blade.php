@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Категории прайса</h2>
        <a href="{{ route('admin.price-categories.create') }}" class="btn btn-primary mb-3">Добавить категорию</a>

        @include('admin.partials.success')

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Файл</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->file && Str::endsWith($category->file, ['jpg', 'jpeg', 'png', 'webp']))
                                <a href="{{ asset('storage/' . $category->file) }}" class="lightbox">
                                    <img src="{{ asset('storage/' . $category->file) }}" alt="{{ $category->name }}"
                                        class="img-fluid rounded" style="max-height: 100px;">
                                </a>
                            @elseif ($category->file && Str::endsWith($category->file, 'pdf'))
                                <a href="{{ asset('storage/' . $category->file) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    Открыть PDF
                                </a>
                            @else
                                <span class="text-muted">Нет файла</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.price-categories.edit', $category) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.price-categories.destroy', $category) }}" method="POST"
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
                        <td colspan="4" class="text-center">Нет категорий</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
