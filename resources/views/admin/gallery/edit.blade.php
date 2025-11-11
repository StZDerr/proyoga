@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Сообщения об успехе --}}
        @include('admin.partials.success')

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Редактировать фото</h2>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>

        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Название --}}
            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $gallery->title) }}" required>
            </div>

            {{-- Описание --}}
            <div class="mb-3">
                <label for="description" class="form-label">Описание (необязательно)</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
            </div>

            {{-- Фото --}}
            <div class="mb-3">
                <label for="image" class="form-label">Фото (только .webp)</label>
                <input type="file" name="image" id="image" class="form-control" accept=".webp">
                @if ($gallery->image)
                    <div class="mt-2">
                        <p>Текущее фото:</p>
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="Фото"
                            style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            {{-- Активна --}}
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Активна</label>
            </div>

            {{-- Порядок --}}
            <div class="mb-3">
                <label for="sort_order" class="form-label">Порядок (число)</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control"
                    value="{{ old('sort_order', $gallery->sort_order ?? 0) }}" min="0">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
