@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Сообщения об успехе --}}
        @include('admin.partials.success')

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Редактировать фото</h2>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $gallery->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание (необязательно)</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
            </div>

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

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
