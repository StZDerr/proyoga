@extends('admin.layouts.app')

@section('title', 'Статьи')

@section('content')
    @include('admin.partials.success')

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Статьи</h2>
                    <div class="page-subtitle">Управление статьями сайта</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Добавить статью
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список статей</h3>
                </div>

                <div class="card-body">
                    @if ($articles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 80px">Изображение</th>
                                        <th>Заголовок</th>
                                        <th>Краткое описание</th>
                                        <th style="width: 120px">Дата</th>
                                        <th class="w-1">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>
                                                @if ($article->image)
                                                    <img src="{{ asset('storage/' . $article->image) }}"
                                                        alt="{{ $article->title }}" class="rounded"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $article->title }}</strong>
                                                <div class="text-muted small">
                                                    {{ $article->slug }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted small">
                                                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 80) }}
                                                </div>
                                            </td>
                                            <td class="text-muted">
                                                {{ $article->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Редактировать">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.articles.destroy', $article) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Вы уверены, что хотите удалить эту статью?')"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Удалить">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="empty">
                            <div class="empty-icon">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                            <p class="empty-title">Статей пока нет</p>
                            <p class="empty-subtitle text-muted">
                                Создайте первую статью для вашего блога
                            </p>
                            <div class="empty-action">
                                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Добавить статью
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
