@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить главную категорию</h2>
        @include('admin.partials.success')

        <form action="{{ route('admin.main-categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.main-categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
