@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Редактировать персонал</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @include('admin.partials.success')

        <form action="{{ route('admin.personal.update', $personal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="first_name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="{{ old('first_name', $personal->first_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="{{ old('last_name', $personal->last_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="middle_name" class="form-label">Отчество</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name"
                    value="{{ old('middle_name', $personal->middle_name) }}">
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Должность</label>
                <input type="text" class="form-control" id="position" name="position"
                    value="{{ old('position', $personal->position) }}" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Фотография</label>
                @if ($personal->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $personal->photo) }}" alt="Фото" style="width:100px;">
                    </div>
                @endif
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.personal.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
