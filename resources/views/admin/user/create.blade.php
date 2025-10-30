@extends('admin.layouts.app')

@section('title', 'Добавить пользователя')

@section('content')
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Добавить пользователя</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>

        <div class="card p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" name="login" id="login" class="form-control" value="{{ old('login') }}"
                        required>
                    @error('login')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 mt-3">
                    <i class="bi bi-person-plus me-2"></i>Создать пользователя
                </button>
            </form>
        </div>
    </div>
@endsection
