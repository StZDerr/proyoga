@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Часто задаваемые вопросы</h2>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">Добавить вопрос</a>
        </div>

        @include('admin.partials.success')

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Вопрос</th>
                    <th>Порядок</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question }}</td>
                        <td>{{ $question->order }}</td>
                        <td>
                            <a href="{{ route('admin.questions.edit', $question->id) }}"
                                class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Удалить вопрос?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Вопросов пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
