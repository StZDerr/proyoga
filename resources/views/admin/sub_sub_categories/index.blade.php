@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Подподкатегории</h2>

        @include('admin.partials.success')

        <a href="{{ route('admin.sub-sub-categories.create') }}" class="btn btn-primary mb-3">Добавить подподкатегорию</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>О программе</th>
                    <th>Преимущества</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subSubCategories as $subSub)
                    <tr>
                        <td>{{ $subSub->id }}</td>
                        <td>{{ $subSub->title }}</td>
                        <td>{{ $subSub->description }}</td>
                        <td>{{ $subSub->about }}</td>
                        <td>
                            <ul>
                                @foreach ($subSub->benefits ?? [] as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if ($subSub->image)
                                <img src="{{ asset('storage/' . $subSub->image) }}" alt="{{ $subSub->title }}" width="100">
                            @endif
                        </td>
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
                        <td colspan="7">Подподкатегорий нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
