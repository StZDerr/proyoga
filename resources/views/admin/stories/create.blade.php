@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.partials.success')

        <h2>Добавить историю</h2>

        <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input id="title" name="title" value="{{ old('title') }}"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="preview" class="form-label">Превью (обязательно, изображение)</label>
                <input id="preview" name="preview" type="file" accept="image/*"
                    class="form-control @error('preview') is-invalid @enderror" required>
                @error('preview')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="media" class="form-label">Медиа (одно или несколько: фото или видео)</label>
                <input id="media" name="media[]" type="file" accept="image/*,video/*"
                    class="form-control @error('media') is-invalid @enderror" multiple required>
                @error('media')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('media.*')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
