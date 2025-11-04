@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.partials.success')
        <h2>{{ isset($promotion) ? 'Редактировать акцию' : 'Добавить акцию' }}</h2>

        <form
            action="{{ isset($promotion) ? route('admin.promotions.update', $promotion->id) : route('admin.promotions.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($promotion))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="photo" class="form-label">Фото (WEBP, max 1МБ)</label>
                <input type="file" name="photo" id="photo" class="form-control"
                    {{ isset($promotion) ? '' : 'required' }}>
            </div>

            @if (isset($promotion) && $promotion->photo)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $promotion->photo) }}" width="200" alt="Фото акции">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
