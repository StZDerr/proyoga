@extends('admin.layouts.app')

@section('content')
    @php
        $formatSize = fn($bytes, $decimals = 2) => $bytes === null
            ? '—'
            : ($bytes === 0
                ? '0 B'
                : (function ($b, $d) {
                    $k = 1024;
                    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
                    $i = floor(log($b, $k));
                    return round($b / pow($k, $i), $d) . ' ' . $sizes[$i];
                })($bytes, $decimals));
    @endphp
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
                    <th>Название</th>
                    <th>Условие</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th>Фото</th>
                    <th>Размер</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promotion)
                    <tr>
                        <td>{{ $promotion->id }}</td>
                        <td>{{ $promotion->title }}</td>
                        <td>{{ $promotion->description }}</td>
                        <td>{{ $promotion->start_date }}</td>
                        <td>{{ $promotion->end_date }}</td>
                        <td>{{ $formatSize($promotion->photo_size) }}</td>
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
