@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить подподкатегорию</h2>

        @include('admin.partials.success')

        <form action="{{ route('admin.sub-sub-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">О программе</label>
                <textarea name="about" class="form-control">{{ old('about') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Изображение (webp, макс. 2МБ)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Преимущества</label>
                <div id="benefits-container">
                    <input type="text" name="benefits[]" class="form-control mb-2" placeholder="Преимущество">
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addBenefit()">+ Добавить
                    преимущество</button>
            </div>

            <div class="mb-3">
                <label class="form-label">Подкатегория</label>
                <select name="sub_category_id" class="form-select" required>
                    <option value="">Выберите подкатегорию</option>
                    @foreach ($subCategories as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->title }} ({{ $sub->mainCategory->title }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

    <script>
        function addBenefit() {
            const container = document.getElementById('benefits-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'benefits[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Преимущество';
            container.appendChild(input);
        }
    </script>
@endsection
