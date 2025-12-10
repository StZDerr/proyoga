@extends('admin.layouts.app')

@section('title', 'Внешние сервисы - Создание сервиса')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Добавить внешний сервис</h1>

        <a href="{{ route('admin.external-services.index') }}" class="btn btn-secondary">
            Назад
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.external-services.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Название сервиса</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Key --}}
                <div class="mb-3">
                    <label class="form-label">Ключ (ID счётчика / Pixel ID)</label>
                    <input type="text" name="key" class="form-control" value="{{ old('key') }}">
                    @error('key')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Token --}}
                <div class="mb-3">
                    <label class="form-label">Token / API ключ</label>
                    <input type="text" name="token" class="form-control" value="{{ old('token') }}">
                    @error('token')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Script --}}
                <div class="mb-3">
                    <label class="form-label">JS скрипт</label>
                    <textarea name="script" rows="5" class="form-control" placeholder="<script>
                        ...
                    </script>">{{ old('script') }}</textarea>
                    @error('script')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Config --}}
                <div class="mb-3">
                    <label class="form-label">Дополнительная конфигурация (JSON)</label>
                    <textarea name="config" rows="3" class="form-control" placeholder='{"chat_id": "..."}'>{{ old('config') }}</textarea>
                    @error('config')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Active --}}
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" name="active" value="1" class="form-check-input" id="activeSwitch"
                        {{ old('active', 1) ? 'checked' : '' }}>
                    <label for="activeSwitch" class="form-check-label">Активен</label>
                </div>

                <button class="btn btn-primary">
                    Создать
                </button>
            </form>

        </div>
    </div>
@endsection
