@extends('admin.layouts.app')

@section('title', 'Редактировать вопрос')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Редактировать вопрос</h1>
            <a href="{{ route('admin.test.questions') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к списку
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.test.question.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="question" class="form-label">Текст вопроса *</label>
                        <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" rows="3"
                            required>{{ old('question', $question->question) }}</textarea>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                {{ old('is_active', $question->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Активный вопрос
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Варианты ответов *</label>
                        <div id="options-container">
                            @foreach ($question->options as $index => $option)
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('options.' . $index) is-invalid @enderror"
                                            name="options[]" placeholder="Вариант ответа {{ $index + 1 }}"
                                            value="{{ old('options.' . $index, $option->option_text) }}" required>
                                        <button type="button" class="btn btn-outline-danger remove-option"
                                            {{ count($question->options) <= 2 ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @error('options.' . $index)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-option" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus"></i> Добавить вариант
                        </button>
                        <small class="form-text text-muted">Минимум 2 варианта ответа</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.test.questions') }}" class="btn btn-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('options-container');
            const addButton = document.getElementById('add-option');
            let optionCount = {{ count($question->options) }};

            addButton.addEventListener('click', function() {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'option-item mb-2';
                optionDiv.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="options[]" 
                       placeholder="Вариант ответа ${optionCount + 1}" required>
                <button type="button" class="btn btn-outline-danger remove-option">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(optionDiv);
                optionCount++;
                updateRemoveButtons();
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-option')) {
                    e.target.closest('.option-item').remove();
                    optionCount--;
                    updateRemoveButtons();
                    updatePlaceholders();
                }
            });

            function updateRemoveButtons() {
                const removeButtons = container.querySelectorAll('.remove-option');
                removeButtons.forEach(button => {
                    button.disabled = removeButtons.length <= 2;
                });
            }

            function updatePlaceholders() {
                const inputs = container.querySelectorAll('input[name="options[]"]');
                inputs.forEach((input, index) => {
                    input.placeholder = `Вариант ответа ${index + 1}`;
                });
            }
        });
    </script>
@endsection
