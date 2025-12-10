@extends('admin.layouts.app')

@section('title', 'Внешние сервисы')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Внешние сервисы</h1>

        <a href="{{ route('admin.external-services.create') }}" class="btn btn-primary">
            Добавить сервис
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Ключ / Token</th>
                        <th>Активен</th>
                        <th class="text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>

                            <td>{{ $service->name }}</td>

                            <td>
                                @if ($service->key)
                                    <span class="text-muted">key: </span>{{ $service->key }}
                                @elseif($service->token)
                                    <span class="text-muted">token:
                                    </span>{{ \Illuminate\Support\Str::limit($service->token, 20) }}
                                @else
                                    <span class="text-muted">нет</span>
                                @endif
                            </td>

                            <td>
                                @if ($service->active)
                                    <span class="badge bg-success">Да</span>
                                @else
                                    <span class="badge bg-secondary">Нет</span>
                                @endif
                            </td>

                            <td class="text-end">

                                <a href="{{ route('admin.external-services.edit', $service->id) }}"
                                    class="btn btn-sm btn-warning">
                                    Редактировать
                                </a>

                                <form action="{{ route('admin.external-services.destroy', $service->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Удалить сервис?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Удалить
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Сервисов пока нет
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
