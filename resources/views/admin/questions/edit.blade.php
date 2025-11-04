@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.partials.success')
        <h2>{{ isset($question) ? 'Редактировать вопрос' : 'Добавить вопрос' }}</h2>

        <form
            action="{{ isset($question) ? route('admin.questions.update', $question->id) : route('admin.questions.store') }}"
            method="POST">
            @csrf
            @if (isset($question))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="question" class="form-label">Вопрос</label>
                <input type="text" name="question" id="question" class="form-control"
                    value="{{ old('question', $question->question ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="answer" class="form-label">Ответ</label>
                <textarea name="answer" id="answer" rows="5" class="form-control" required>{{ old('answer', $question->answer ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="order" class="form-label">Порядок</label>
                <input type="number" name="order" id="order" class="form-control"
                    value="{{ old('order', $question->order ?? 0) }}">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
