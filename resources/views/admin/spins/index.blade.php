@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Сегменты колеса</h2>
        <a href="{{ route('admin.spins.create') }}" class="btn btn-primary mb-3">Добавить сегмент</a>

        @include('admin.partials.success')

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цвет</th>
                    <th>Шанс (%)</th>
                    <th>Активен</th>
                    <th>Порядок</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prizes as $prize)
                    <tr>
                        <td>{{ $prize->id }}</td>
                        <td>{{ $prize->name }}</td>
                        <td>
                            <div style="width:36px; height:24px; background: {{ $prize->color }}; border:1px solid #ddd;">
                            </div>
                            <div class="text-muted small">{{ $prize->color }}</div>
                        </td>
                        <td>{{ $prize->chance }}</td>
                        <td>{{ $prize->is_active ? 'Да' : 'Нет' }}</td>
                        <td>{{ $prize->order }}</td>
                        <td>
                            <a href="{{ route('admin.spins.edit', $prize) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.spins.destroy', $prize) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Нет сегментов</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
