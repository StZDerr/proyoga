@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <div class="mb-4">
            <h2>Добавить сотрудника</h2>
            <a href="{{ route('admin.personal.index') }}" class="btn btn-secondary">Назад к списку</a>
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
        @include('admin.partials.success')

        <div class="card p-4">
            <form action="{{ route('admin.personal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="last_name" class="form-label">Фамилия</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">Имя</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="middle_name" class="form-label">Отчество</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control"
                        value="{{ old('middle_name') }}">
                    @error('middle_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Должность</label>
                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}"
                        required>
                    @error('position')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Фотография</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    @error('photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Добавить сотрудника</button>
            </form>
        </div>
    </div>
@endsection
