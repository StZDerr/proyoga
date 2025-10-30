@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Редактировать пользователя</h2>

        @include('admin.partials.success')

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login"
                    value="{{ old('login', $user->login) }}" required>
                @error('login')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль (оставьте пустым, если не хотите менять)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Назад к списку</a>
        </form>
    </div>
@endsection
