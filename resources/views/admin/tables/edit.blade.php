@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>{{ isset($priceTable) ? 'Редактировать таблицу' : 'Добавить таблицу' }}</h2>

        @include('admin.partials.success')

        <form action="{{ isset($priceTable) ? route('price-tables.update', $priceTable) : route('price-tables.store') }}"
            method="POST">
            @csrf
            @if (isset($priceTable))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Название таблицы</label>
                <input type="text" name="title" class="form-control" value="{{ $priceTable->title ?? old('title') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Категория</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if (isset($priceTable) && $priceTable->category_id == $category->id) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">{{ isset($priceTable) ? 'Сохранить' : 'Добавить' }}</button>
            <a href="{{ route('price-tables.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
