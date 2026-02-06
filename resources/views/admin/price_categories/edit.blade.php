@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>{{ isset($priceCategory) ? 'Редактировать категорию' : 'Добавить категорию' }}</h2>

        @include('admin.partials.success')

        <form
            action="{{ isset($priceCategory) ? route('admin.price-categories.update', $priceCategory) : route('admin.price-categories.store') }}"
            method="POST">
            @csrf
            @if (isset($priceCategory))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Название категории</label>
                <input type="text" name="name" class="form-control" value="{{ $priceCategory->name ?? old('name') }}"
                    required>
            </div>

            <button type="submit" class="btn btn-success">{{ isset($priceCategory) ? 'Сохранить' : 'Добавить' }}</button>
            <a href="{{ route('admin.price-categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
