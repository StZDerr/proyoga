@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Редактировать персонал</h2>


        <form action="{{ route('admin.personal.update', $personal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="first_name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="{{ old('first_name', $personal->first_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Фамилия</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="{{ old('last_name', $personal->last_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug (optional)</label>
                <input type="text" class="form-control" id="slug" name="slug"
                    value="{{ old('slug', $personal->slug) }}">
                <small class="text-muted">Если оставить пустым — сгенерируется автоматически</small>
            </div>

            <div class="mb-3">
                <label for="middle_name" class="form-label">Отчество</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name"
                    value="{{ old('middle_name', $personal->middle_name) }}">
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Должность</label>
                <input type="text" class="form-control" id="position" name="position"
                    value="{{ old('position', $personal->position) }}" required>
            </div>

            <div class="mb-3">
                <label for="sort_order" class="form-label">Порядок</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order"
                    value="{{ old('sort_order', $personal->sort_order ?? 0) }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $personal->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Фото (главное)</label>
                @if ($personal->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $personal->photo) }}" alt="Фото" style="width:100px;">
                    </div>
                @endif
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            @if ($personal->photos->count())
                <div class="mb-3">
                    <label class="form-label">Галерея</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($personal->photos as $photo)
                            <div class="card" style="width:110px;">
                                <img src="{{ asset('storage/' . $photo->path) }}" class="card-img-top"
                                    style="height:80px;object-fit:cover;">
                                <div class="card-body p-2 text-center">
                                    <button type="button" class="btn btn-sm btn-danger js-delete-photo"
                                        data-url="{{ route('admin.personal.photos.destroy', [$personal, $photo]) }}">Удалить</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="photos" class="form-label">Добавить фотографии (несколько)</label>
                <input type="file" class="form-control" id="photos" name="photos[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('admin.personal.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.js-delete-photo').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Удалить фото?')) return;
                    const url = this.dataset.url;
                    const card = this.closest('.card');
                    this.disabled = true;
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                            },
                        })
                        .then(res => {
                            if (res.status >= 200 && res.status < 300) {
                                const ct = res.headers.get('content-type') || '';
                                if (ct.indexOf('application/json') !== -1) {
                                    return res.json();
                                }
                                return {};
                            }
                            return res.text().then(t => {
                                throw new Error(t || 'Network response was not ok');
                            });
                        })
                        .then(() => {
                            if (card) card.remove();
                        })
                        .catch((err) => {
                            console.error('Delete photo error:', err);
                            alert('Не удалось удалить фото. Попробуйте ещё раз.');
                            this.disabled = false;
                        });
                });
            });
        });
    </script>
@endsection
