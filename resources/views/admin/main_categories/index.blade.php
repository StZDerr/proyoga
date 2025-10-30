@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Главные категории</h2>
        @include('admin.partials.success')
        <a href="{{ route('admin.main-categories.create') }}" class="btn btn-primary mb-3">Добавить категорию</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mainCategories as $category)
                    <tr>
                        <td>{{ $category->title }}</td>
                        <td>
                            <a href="{{ route('admin.main-categories.edit', $category) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.main-categories.destroy', $category) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить категорию?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Нет категорий</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
