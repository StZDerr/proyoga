@extends('admin.layouts.app')

@section('title', 'Управление страницами')
@section('header', 'Управление страницами')

@section('content')
    @include('admin.partials.success')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Управление страницами
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fas fa-plus me-1"></i>
                            Добавить страницу
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    @if ($pages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Slug</th>
                                        <th>Заголовок</th>
                                        <th>Описание</th>
                                        <th>Статус</th>
                                        <th class="w-1">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $page)
                                        <tr>
                                            <td>
                                                <code class="text-primary">{{ $page->slug }}</code>
                                            </td>
                                            <td>{{ $page->title }}</td>
                                            <td class="text-muted">{{ Str::limit($page->description, 60) }}</td>
                                            <td>
                                                @if ($page->is_active)
                                                    <span class="badge bg-green">Активна</span>
                                                @else
                                                    <span class="badge bg-secondary">Неактивна</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-list">
                                                    <a href="{{ route('admin.pages.edit', $page) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Редактировать">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Удалить"
                                                            onclick="return confirm('Вы уверены, что хотите удалить эту страницу?')">
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
                    @else
                        <div class="empty">
                            <div class="empty-icon">
                                <i class="fas fa-file-alt fa-3x text-muted"></i>
                            </div>
                            <p class="empty-title">Страниц пока нет</p>
                            <p class="empty-subtitle text-muted">
                                Создайте первую страницу для управления контентом
                            </p>
                            <div class="empty-action">
                                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>
                                    Добавить страницу
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
