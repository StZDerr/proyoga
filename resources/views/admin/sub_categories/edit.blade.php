@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать подкатегорию</h2>
        @include('admin.partials.success')

        <form action="{{ route('admin.sub-categories.update', $subCategory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Главная категория</label>
                <select name="main_category_id" class="form-select" required>
                    @foreach ($mainCategories as $main)
                        <option value="{{ $main->id }}" @if ($subCategory->main_category_id == $main->id) selected @endif>
                            {{ $main->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ $subCategory->title }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control" rows="3">{{ $subCategory->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Изображение</label>
                <input type="file" name="image" class="form-control" accept=".webp">
                @if ($subCategory->image)
                    <img src="{{ asset('storage/' . $subCategory->image) }}" width="100" class="mt-2" alt="">
                @endif
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
