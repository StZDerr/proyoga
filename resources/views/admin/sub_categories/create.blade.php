@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить подкатегорию</h2>
        @include('admin.partials.success')

        <form action="{{ route('admin.sub-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Главная категория</label>
                <select name="main_category_id" class="form-select" required>
                    <option value="">Выберите категорию</option>
                    @foreach ($mainCategories as $main)
                        <option value="{{ $main->id }}">{{ $main->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Изображение</label>
                <input type="file" name="image" class="form-control" accept=".webp">
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
