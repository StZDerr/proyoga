@extends('admin.layouts.app')

@section('title', 'Результаты тестов')

@section('content')
    <div class="container-fluid">
        @include('admin.partials.success')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Результаты тестов</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th>Дата прохождения</th>
                                <th>Посетил занятие</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->id }}</td>
                                    <td>{{ $submission->name }}</td>
                                    <td>{{ $submission->phone }}</td>
                                    <td>{{ $submission->email ?: '-' }}</td>
                                    <td>{{ $submission->completed_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if ($submission->visited_free_class)
                                            <span class="badge bg-success">Да</span>
                                        @else
                                            <span class="badge bg-warning">Нет</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.test.submission.show', $submission->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Подробнее
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Результатов тестов пока нет</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $submissions->links() }}
            </div>
        </div>
    </div>
@endsection
