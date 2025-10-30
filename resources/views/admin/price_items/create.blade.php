@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>{{ isset($priceItem) ? 'Редактировать элемент' : 'Добавить элемент' }}</h2>

        @include('admin.partials.success')

        <form
            action="{{ isset($priceItem) ? route('admin.price-items.update', $priceItem) : route('admin.price-items.store') }}"
            method="POST">
            @csrf
            @if (isset($priceItem))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control" value="{{ $priceItem->name ?? old('name') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Длительность</label>
                <input type="text" name="duration" class="form-control"
                    value="{{ $priceItem->duration ?? old('duration') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="text" name="price" class="form-control" value="{{ $priceItem->price ?? old('price') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Таблица</label>
                <select name="table_id" class="form-select" required>
                    <option value="">Выберите таблицу</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}" @if (isset($priceItem) && $priceItem->table_id == $table->id) selected @endif>
                            {{ $table->title }} ({{ $table->category->name ?? 'Без категории' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                {{ isset($priceItem) ? 'Сохранить' : 'Добавить' }}
            </button>
            <a href="{{ route('admin.price-items.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
