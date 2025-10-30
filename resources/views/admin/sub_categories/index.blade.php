@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Подкатегории</h2>
        @include('admin.partials.success')
        <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary mb-3">Добавить подкатегорию</a>

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
                            <form action="{{ route('admin.sub-categories.destroy', $sub) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить подкатегорию?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Нет подкатегорий</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
