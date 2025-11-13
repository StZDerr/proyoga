@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Просмотр вопроса: {{ $subSubCategory->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub_sub_categories.index') }}">Подподкатегории</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub_sub_categories.edit', $subSubCategory->id) }}">{{ $subSubCategory->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}">Вопросы и ответы</a></li>
                    <li class="breadcrumb-item active">Просмотр вопроса</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Вопрос</h5>
                </div>
                <div class="card-body">
                    <p class="lead">{{ $faq->question }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ответ</h5>
                </div>
                <div class="card-body">
                    <p style="white-space: pre-wrap;">{{ $faq->answer }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Назад к списку
                </a>
                <a href="{{ route('admin.sub-sub-category-faqs.edit', [$subSubCategory->id, $faq->id]) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFaqModal">
                    <i class="fas fa-trash"></i> Удалить
                </button>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Информация</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Подподкатегория:</dt>
                        <dd class="col-sm-7">{{ $subSubCategory->name }}</dd>

                        <dt class="col-sm-5">Подкатегория:</dt>
                        <dd class="col-sm-7">{{ $subSubCategory->subCategory->name ?? 'Не указано' }}</dd>

                        <dt class="col-sm-5">Автор:</dt>
                        <dd class="col-sm-7">{{ $faq->user->name ?? 'Неизвестно' }}</dd>

                        <dt class="col-sm-5">Создан:</dt>
                        <dd class="col-sm-7">{{ $faq->created_at->format('d.m.Y H:i') }}</dd>

                        <dt class="col-sm-5">Изменён:</dt>
                        <dd class="col-sm-7 mb-0">{{ $faq->updated_at->format('d.m.Y H:i') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Статистика подподкатегории</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Всего вопросов:</strong> {{ $subSubCategory->faqs()->count() }}</p>
                    <p class="mb-0">
                        <a href="{{ route('admin.sub-sub-category-faqs.index', $subSubCategory->id) }}">
                            Перейти ко всем вопросам 
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFaqModal" tabindex="-1" aria-labelledby="deleteFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFaqModalLabel">Подтверждение удаления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить этот вопрос?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form action="{{ route('admin.sub-sub-category-faqs.destroy', [$subSubCategory->id, $faq->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection