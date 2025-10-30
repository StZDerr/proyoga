@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Акции</h2>
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">Добавить акцию</a>
        </div>

        @include('admin.partials.success')

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promotion)
                    <tr>
                        <td>{{ $promotion->id }}</td>
                        <td><img src="{{ asset('storage/' . $promotion->photo) }}" width="150" alt="Фото акции"></td>
                        <td>
                            <a href="{{ route('admin.promotions.edit', $promotion->id) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить акцию?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Акций пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
