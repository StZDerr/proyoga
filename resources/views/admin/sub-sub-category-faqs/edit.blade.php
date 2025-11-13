@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Редактировать вопрос: {{ $subSubCategory->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub_sub_categories.index') }}">Подподкатегории</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub_sub_categories.edit', $subSubCategory->id) }}">{{ $subSubCategory->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}">Вопросы и ответы</a></li>
                    <li class="breadcrumb-item active">Редактировать вопрос</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.sub-sub-category-faqs.update', [$subSubCategory->id, $faq->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="question" class="form-label">Вопрос <span class="text-danger">*</span></label>
                            <textarea 
                                name="question" 
                                id="question" 
                                class="form-control @error('question') is-invalid @enderror" 
                                rows="3" 
                                required>{{ old('question', $faq->question) }}</textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Введите вопрос, который часто задают пользователи</small>
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">Ответ <span class="text-danger">*</span></label>
                            <textarea 
                                name="answer" 
                                id="answer" 
                                class="form-control @error('answer') is-invalid @enderror" 
                                rows="6" 
                                required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Введите подробный ответ на вопрос</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Назад
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Информация о вопросе</h5>
                </div>
                <div class="card-body">
                    <p><strong>Подподкатегория:</strong> {{ $subSubCategory->name }}</p>
                    <p><strong>Подкатегория:</strong> {{ $subSubCategory->subCategory->name ?? 'Не указано' }}</p>
                    <p><strong>Автор:</strong> {{ $faq->user->name ?? 'Неизвестно' }}</p>
                    <p><strong>Создан:</strong> {{ $faq->created_at->format('d.m.Y H:i') }}</p>
                    <p class="mb-0"><strong>Изменён:</strong> {{ $faq->updated_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Действия</h5>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteFaqModal">
                        <i class="fas fa-trash"></i> Удалить вопрос
                    </button>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Советы</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Формулируйте вопрос так, как его задают пользователи</li>
                        <li>Давайте полные и понятные ответы</li>
                        <li>Используйте простой язык</li>
                        <li>Избегайте технических терминов</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFaqModal" tabindex="-1" aria-labelledby="deleteFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFaqModalLabel">Подтверждение удаления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить этот вопрос?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form action="{{ route('admin.sub-sub-category-faqs.destroy', [$subSubCategory->id, $faq->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection