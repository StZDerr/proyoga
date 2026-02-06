@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Категории прайса</h2>
        <a href="{{ route('admin.price-categories.create') }}" class="btn btn-primary mb-3">Добавить категорию</a>

        @include('admin.partials.success')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
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
                        <td colspan="3">Нет категорий</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
