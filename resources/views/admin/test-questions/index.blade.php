@extends('admin.layouts.app')

@section('title', 'Управление вопросами теста')

@section('content')
    <div class="container-fluid">
        @include('admin.partials.success')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Вопросы теста</h1>
            <a href="{{ route('admin.test.question.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить вопрос
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @forelse($questions as $question)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">
                                    Вопрос {{ $question->order_position }}
                                    @if (!$question->is_active)
                                        <span class="badge bg-secondary">Неактивен</span>
                                    @endif
                                </h6>
                            </div>
                            <div>
                                <a href="{{ route('admin.test.question.edit', $question->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Редактировать
                                </a>
                                <form action="{{ route('admin.test.question.delete', $question->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Вы уверены?')">
                                        <i class="fas fa-trash"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-3"><strong>{{ $question->question }}</strong></p>
                            <div class="row">
                                @foreach ($question->options as $option)
                                    <div class="col-md-6 mb-2">
                                        <div class="p-2 bg-light rounded">
                                            {{ $option->option_text }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p>Вопросов пока нет</p>
                        <a href="{{ route('admin.test.question.create') }}" class="btn btn-primary">
                            Добавить первый вопрос
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
