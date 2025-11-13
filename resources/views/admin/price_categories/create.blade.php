@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>{{ isset($priceCategory) ? 'Редактировать категорию' : 'Добавить категорию' }}</h2>

        @include('admin.partials.success')

        <form
            action="{{ isset($priceCategory) ? route('admin.price-categories.update', $priceCategory) : route('admin.price-categories.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($priceCategory))
                @method('PUT')
            @endif

            <!-- Название категории -->
            <div class="mb-3">
                <label class="form-label">Название категории</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $priceCategory->name ?? '') }}"
                    required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Файл JPG / PNG / PDF -->
            <div class="mb-3">
                <label class="form-label">Файл (JPG, PNG, PDF)</label>
                <input type="file" name="file" class="form-control">
                @if (isset($priceCategory) && $priceCategory->file)
                    <div class="mt-2">
                        @if (Str::endsWith($priceCategory->file, ['jpg', 'jpeg', 'png', 'webp']))
                            <a href="{{ asset('storage/' . $priceCategory->file) }}" class="lightbox">
                                <img src="{{ asset('storage/' . $priceCategory->file) }}" alt="{{ $priceCategory->name }}"
                                    class="img-fluid rounded" style="max-height: 100px;">
                            </a>
                        @elseif (Str::endsWith($priceCategory->file, 'pdf'))
                            <a href="{{ asset('storage/' . $priceCategory->file) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                Открыть PDF
                            </a>
                        @endif
                    </div>
                @endif
                @error('file')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Кнопки -->
            <button type="submit" class="btn btn-success">
                {{ isset($priceCategory) ? 'Сохранить' : 'Добавить' }}
            </button>
            <a href="{{ route('admin.price-categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
