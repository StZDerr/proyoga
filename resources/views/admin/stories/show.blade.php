@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>{{ $story->title }}</h2>

        @if ($story->preview)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $story->preview) }}" alt="preview" style="max-width:480px;" class="img-fluid">
            </div>
        @endif

        @if ($story->media->count() > 0)
            <div class="mb-3">
                <h4>Медиа</h4>
                <div class="row">
                    @foreach ($story->media as $media)
                        <div class="col-md-6 mb-3">
                            @if ($media->type === 'photo')
                                <img src="{{ asset('storage/' . $media->path) }}" alt="photo" class="img-fluid">
                            @else
                                <video controls class="w-100">
                                    <source src="{{ asset('storage/' . $media->path) }}">
                                </video>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('admin.stories.edit', $story) }}" class="btn btn-warning">Редактировать</a>
        <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
