@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Таблицы прайса</h2>
        <a href="{{ route('admin.price-tables.create') }}" class="btn btn-primary mb-3">Добавить таблицу</a>

        @include('admin.partials.success')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название таблицы</th>
                    <th>Категория</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $table)
                    <tr>
                        <td>{{ $table->id }}</td>
                        <td>{{ $table->title }}</td>
                        <td>{{ $table->category->name }}</td>
                        <td>
                            <a href="{{ route('admin.price-tables.edit', $table) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.price-tables.destroy', $table) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Нет таблиц</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
