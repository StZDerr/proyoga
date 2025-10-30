@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Элементы прайса</h2>
        <a href="{{ route('price-items.create') }}" class="btn btn-primary mb-3">Добавить элемент</a>

        @include('admin.partials.success')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Длительность</th>
                    <th>Цена</th>
                    <th>Таблица</th>
                    <th>Категория</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->duration }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->table->title }}</td>
                        <td>{{ $item->table->category->name }}</td>
                        <td>
                            <a href="{{ route('price-items.edit', $item) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('price-items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Нет элементов</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
