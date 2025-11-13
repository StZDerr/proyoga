@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                <h1>Добавить вопрос: {{ $subSubCategory->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.sub-sub-categories.index') }}">Подподкатегории</a></li>
                        {{-- <li class="breadcrumb-item"><a
                                href="{{ route('admin.sub-sub-categories.edit', $subSubCategory->id) }}">{{ $subSubCategory->title }}</a>
                        </li> --}}
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}">Вопросы и
                                ответы</a></li>
                        <li class="breadcrumb-item active">Добавить вопрос</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.sub-sub-category-faqs.store', $subSubCategory->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="question" class="form-label">Вопрос <span class="text-danger">*</span></label>
                                <textarea name="question" id="question" class="form-control @error('question') is-invalid @enderror" rows="3"
                                    required>{{ old('question') }}</textarea>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Введите вопрос, который часто задают
                                    пользователи</small>
                            </div>

                            <div class="mb-3">
                                <label for="answer" class="form-label">Ответ <span class="text-danger">*</span></label>
                                <textarea name="answer" id="answer" class="form-control @error('answer') is-invalid @enderror" rows="6"
                                    required>{{ old('answer') }}</textarea>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Введите подробный ответ на вопрос</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}"
                                    class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Назад
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Информация</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Подподкатегория:</strong> {{ $subSubCategory->title }}</p>
                        <p><strong>Подкатегория:</strong> {{ $subSubCategory->subCategory->title ?? 'Не указано' }}</p>
                        <p class="mb-0"><strong>Всего вопросов:</strong> {{ $subSubCategory->faqs()->count() }}</p>
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
@endsection
