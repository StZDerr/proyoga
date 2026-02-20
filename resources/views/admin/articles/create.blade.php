@extends('admin.layouts.app')

@section('title', 'Создание статьи')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Создание статьи</h2>
                    <div class="page-subtitle">Добавление новой статьи</div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Назад к списку
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3" style="overflow: visible;">
                            <div class="card-header">
                                <h3 class="card-title">Основная информация</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">Заголовок</label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" placeholder="Введите заголовок статьи" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Краткое описание (excerpt)</label>
                                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3"
                                        placeholder="Краткое описание для превью статьи (до 500 символов)">{{ old('excerpt') }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Это описание будет отображаться в списке статей и
                                        превью</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Содержимое статьи</label>
                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" data-ckeditor="true"
                                        data-upload-url="{{ route('admin.articles.upload-image') }}" style="min-height: 800px;">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Изображение</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Главное изображение</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Рекомендуемый размер: 1200x630px, WebP, 200кб</small>
                                </div>

                                <div id="image-preview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i>
                                    Создать статью
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('image-preview');
                preview.src = reader.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
