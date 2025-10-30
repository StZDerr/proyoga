@extends('admin.layouts.app')

@section('title', 'Панель управления')

@section('content')
    <div class="main m-5">
        @include('admin.partials.success')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Пользователи</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Добавить пользователя
            </a>
        </div>

        <div class="card p-3">
            <h5 class="mb-3">Список пользователей</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Дата регистрации</th>
                            <th class="text-end">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-outline-warning me-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Удалить пользователя?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Пользователи не найдены
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
