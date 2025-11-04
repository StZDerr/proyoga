@extends('admin.layouts.app')

@section('title', 'Результат теста')

@section('content')
    <div class="container-fluid">
        @include('admin.partials.success')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Результат теста #{{ $submission->id }}</h1>
            <a href="{{ route('admin.test.submissions') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к списку
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Контактная информация</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Имя:</strong></td>
                                <td>{{ $submission->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Телефон:</strong></td>
                                <td>{{ $submission->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $submission->email ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Дата прохождения:</strong></td>
                                <td>{{ $submission->completed_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Посетил бесплатное занятие:</strong></td>
                                <td>
                                    @if ($submission->visited_free_class)
                                        <span class="badge bg-success">Да</span>
                                    @else
                                        <span class="badge bg-warning">Нет</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <form action="{{ route('admin.test.submission.mark-visited', $submission->id) }}" method="POST"
                            class="mt-3">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="visited" id="visited"
                                    {{ $submission->visited_free_class ? 'checked' : '' }}>
                                <label class="form-check-label" for="visited">
                                    Отметить как посетившего бесплатное занятие
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Ответы на вопросы теста</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($submission->answers as $index => $answer)
                            <div class="mb-4 p-3 border rounded">
                                <h6 class="text-primary">Вопрос {{ $index + 1 }}</h6>
                                <p class="mb-2"><strong>{{ $answer->question->question }}</strong></p>
                                <p class="mb-0">
                                    <i class="fas fa-check-circle text-success"></i>
                                    {{ $answer->option->option_text }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
