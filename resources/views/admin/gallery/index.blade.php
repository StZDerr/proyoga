@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Сообщения об успехе --}}
        @include('admin.partials.success')

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Фотогалерея</h2>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Добавить фото</a>
        </div>

        @if ($galleries->isEmpty())
            <p>Фотографии отсутствуют.</p>
        @else
            <div class="row g-3">
                @foreach ($galleries as $photo)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top" alt="{{ $photo->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->title }}</h5>
                                @if ($photo->description)
                                    <p class="card-text">{{ $photo->description }}</p>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.gallery.edit', $photo) }}"
                                        class="btn btn-sm btn-warning">Редактировать</a>

                                    <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить это фото?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
