@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Сотрудники</h2>
            <a href="{{ route('admin.personal.create') }}" class="btn btn-primary">Добавить сотрудника</a>
        </div>

        @include('admin.partials.success')

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Фото</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Должность</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personals as $personal)
                            <tr>
                                <td>{{ $personal->id }}</td>
                                <td>
                                    @if ($personal->photo)
                                        <img src="{{ asset('storage/' . $personal->photo) }}"
                                            alt="{{ $personal->first_name }}" width="50" class="rounded-circle">
                                    @else
                                        <span class="text-muted">Нет фото</span>
                                    @endif
                                </td>
                                <td>{{ $personal->last_name }}</td>
                                <td>{{ $personal->first_name }}</td>
                                <td>{{ $personal->middle_name ?? '-' }}</td>
                                <td>{{ $personal->position }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.personal.edit', $personal->id) }}"
                                        class="btn btn-sm btn-warning">Редактировать</a>

                                    <form action="{{ route('admin.personal.destroy', $personal->id) }}" method="POST"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить сотрудника?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Сотрудники не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
