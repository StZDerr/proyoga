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
            <div id="gallery-list" class="row g-3" role="list" aria-label="Фотогалерея — порядок изображений"
                data-reorder-url="{{ route('admin.gallery.reorder') }}">
                @foreach ($galleries as $photo)
                    <div class="col-12 col-md-4 col-lg-3 gallery-item" data-id="{{ $photo->id }}" role="listitem">
                        <div class="card h-100 draggable-card" title="Перетащите для смены позиции">
                            <div class="img-wrapper">
                                <img src="{{ asset('storage/' . $photo->image) }}" class="card-img-top gallery-img"
                                    alt="{{ $photo->title }}" />
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $photo->title }}</h5>

                                @if ($photo->description)
                                    <p class="card-text">{{ $photo->description }}</p>
                                @endif

                                {{-- Статус под заголовком --}}
                                <div class="mb-2">
                                    <form action="{{ route('admin.gallery.toggle-active', $photo) }}" method="POST"
                                        class="m-0">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-full {{ $photo->is_active ? 'btn-success' : 'btn-secondary' }}"
                                            aria-pressed="{{ $photo->is_active ? 'true' : 'false' }}"
                                            title="{{ $photo->is_active ? 'Активна — нажмите, чтобы отключить' : 'Неактивна — нажмите, чтобы включить' }}">
                                            @if ($photo->is_active)
                                                <i class="bi bi-check"></i>
                                            @else
                                                <i class="bi bi-x"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>

                                {{-- Кнопки во всю ширину (две колонки) --}}
                                <div class="btn-row mb-2" role="group" aria-label="Действия с фото">
                                    <a href="{{ route('admin.gallery.edit', $photo) }}" class="btn btn-warning btn-full"
                                        aria-label="Редактировать {{ $photo->title }}" title="Редактировать">
                                        <!-- edit svg (currentColor) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.792 9.792a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168L12.146.854zM11.207 2L3 10.207V12h1.793L14 3.793 11.207 2z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить это фото?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-full" title="Удалить"
                                            aria-label="Удалить {{ $photo->title }}">
                                            <!-- trash svg -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                                aria-hidden="true" focusable="false">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5V6h1v8a2 2 0 0 1-2 2H4.5a2 2 0 0 1-2-2V6h1v-.5zM4.118 4 4 4.059V5h8V4.059L11.882 4H9.5l-.5-.5h-2l-.5.5H4.118zM2.5 3a1 1 0 0 1 1-1h1.11l.4-.4A1 1 0 0 1 6.5 1h3a1 1 0 0 1 .49.6l.4.4H12a1 1 0 0 1 1 1v1h-11V3z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                {{-- Номер порядка — отдельный блок во всю ширину --}}
                                <div>
                                    <span class="badge bg-primary text-white d-block w-100 text-center py-2">
                                        {{ $photo->sort_order }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
