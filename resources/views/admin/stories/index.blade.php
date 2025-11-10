@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">

        {{-- Сообщения об успехе --}}
        @include('admin.partials.success')

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Истории</h2>
            <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">Добавить Историю</a>
        </div>

        @if ($stories->isEmpty())
            <p>Истории отсутствуют.</p>
        @else
            <div class="row g-3">
                @foreach ($stories as $story)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card h-100">
                            @php
                                $imgPath = $story->preview ?? ($story->media->first()->path ?? null);
                            @endphp
                            @if ($imgPath)
                                <img src="{{ asset('storage/' . $imgPath) }}" class="card-img-top" alt="{{ $story->title }}">
                            @else
                                <img src="{{ asset('images/placeholder-200x200.png') }}" class="card-img-top"
                                    alt="Нет изображения">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $story->title }}</h5>
                                @if ($story->description)
                                    <p class="card-text">{{ $story->description }}</p>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.stories.edit', $story) }}"
                                        class="btn btn-sm btn-warning">Редактировать</a>

                                    <form action="{{ route('admin.stories.destroy', $story) }}" method="POST"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить эту историю?');">
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
