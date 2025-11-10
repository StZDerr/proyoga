@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('admin.partials.success')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>Редактировать историю</h2>

        <form action="{{ route('admin.stories.update', $story) }}" method="POST" enctype="multipart/form-data" class="mt-3"
            id="story-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input id="title" name="title" value="{{ old('title', $story->title) }}"
                    class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($story->preview)
                <div class="mb-3">
                    <label class="form-label">Текущее превью</label>
                    <div>
                        <img src="{{ asset('storage/' . $story->preview) }}" alt="preview"
                            style="max-width:240px; height:auto;" class="img-thumbnail">
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="preview" class="form-label">Заменить превью (необязательно)</label>
                <input id="preview" name="preview" type="file" accept="image/*"
                    class="form-control @error('preview') is-invalid @enderror">
                @error('preview')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Текущее медиа</label>
                <div class="row">
                    @forelse ($story->media as $media)
                        <div class="col-md-4 mb-3" id="media-{{ $media->id }}">
                            <div class="card">
                                <div class="card-body">
                                    @if ($media->type === 'photo')
                                        <img src="{{ asset('storage/' . $media->path) }}" alt="photo" class="img-fluid"
                                            style="max-height: 200px;">
                                    @else
                                        <video controls class="w-100" style="max-height: 200px;">
                                            <source src="{{ asset('storage/' . $media->path) }}">
                                        </video>
                                    @endif
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-danger btn-sm delete-media-btn"
                                            data-media-id="{{ $media->id }}"
                                            data-url="{{ route('admin.stories.media.destroy', [$story, $media]) }}">
                                            Удалить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-muted">Медиа отсутствует</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mb-3">
                <label for="media" class="form-label">Добавить медиа (необязательно, можно выбрать несколько)</label>
                <input id="media" name="media[]" type="file" accept="image/*,video/*" multiple
                    class="form-control @error('media.*') is-invalid @enderror">
                @error('media.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success" id="update-story-btn">Обновить</button>
            <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('story-form');
            const submitBtn = document.getElementById('update-story-btn');

            // Показываем индикатор загрузки при отправке формы
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Загрузка...';
            });

            // Обработка удаления медиа
            document.querySelectorAll('.delete-media-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (!confirm('Удалить это медиа?')) return;

                    const url = this.getAttribute('data-url');
                    const mediaId = this.getAttribute('data-media-id');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('media-' + mediaId).remove();
                                location.reload();
                            } else {
                                alert(data.error || 'Ошибка при удалении медиа');
                            }
                        })
                        .catch(() => alert('Ошибка при удалении медиа'));
                });
            });
        });
    </script>
@endpush
