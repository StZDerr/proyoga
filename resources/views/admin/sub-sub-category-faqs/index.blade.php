@extends('admin.layouts.app')

@section('title', 'FAQ — Все вопросы')

@section('content')
    <div class="container">
        <div class="page-header d-print-none mb-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Все вопросы и ответы
                    </h2>
                    <div class="page-subtitle text-muted">
                        Управление FAQ для всех подподкатегорий
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="btn-list">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqCreateModal">
                            <i class="fas fa-plus me-1"></i> Добавить вопрос
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.partials.success')

        {{-- Фильтр по подподкатегории --}}
        <div class="mb-3">
            <form method="GET" action="{{ route('admin.sub-sub-category-faqs.index') }}" class="row g-2">
                <div class="col-md-4">
                    <select name="sub_sub_category_id" class="form-select">
                        <option value="">Все подподкатегории</option>
                        @foreach ($subSubCategories as $subSubCategory)
                            <option value="{{ $subSubCategory->id }}" @if (request('sub_sub_category_id') == $subSubCategory->id) selected @endif>
                                {{ $subSubCategory->title }} ({{ $subSubCategory->subCategory->title ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary">Применить</button>
                </div>
            </form>
        </div>

        {{-- Таблица FAQ --}}
        <div class="card">
            <div class="card-body">
                @if ($faqs->isEmpty())
                    <div class="empty">
                        <p class="empty-title">Вопросы не добавлены</p>
                        <p class="empty-subtitle text-muted">Пока нет ни одного вопроса.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Подподкатегория</th>
                                    <th>Вопрос</th>
                                    <th class="d-none d-md-table-cell">Ответ</th>
                                    <th>Порядок</th>
                                    <th>Автор</th>
                                    <th>Создано</th>
                                    <th class="w-1">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr id="faq-row-{{ $faq->id }}">
                                        <td>{{ $faq->id }}</td>
                                        <td data-sub-sub-category-id="{{ $faq->sub_sub_category_id }}">
                                            {{ $faq->subSubCategory->title ?? '—' }}
                                        </td>
                                        <td style="max-width: 300px;">{{ $faq->question }}</td>
                                        <td class="d-none d-md-table-cell" style="max-width: 300px;">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($faq->answer), 180) !!}
                                        </td>
                                        <td>{{ $faq->sort_order ?? 0 }}</td>
                                        <td>{{ $faq->author->name ?? '—' }}</td>
                                        <td>{{ $faq->created_at ? $faq->created_at->format('d.m.Y H:i') : '—' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary btn-edit-faq"
                                                    data-faq-id="{{ $faq->id }}"
                                                    data-faq-question="{{ e($faq->question) }}"
                                                    data-faq-answer="{{ e($faq->answer) }}"
                                                    data-faq-sort="{{ $faq->sort_order ?? 0 }}"
                                                    data-action="{{ route('admin.sub-sub-category-faqs.update', $faq) }}"
                                                    title="Редактировать">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form action="{{ route('admin.sub-sub-category-faqs.destroy', $faq) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Удалить вопрос?');">
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

                        {{-- Пагинация --}}
                        <div class="mt-3">
                            {{ $faqs->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal: Create FAQ --}}
    <div class="modal fade" id="faqCreateModal" tabindex="-1" aria-labelledby="faqCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.sub-sub-category-faqs.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="faqCreateModalLabel">Добавить вопрос</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Подподкатегория</label>
                        <select name="sub_sub_category_id" class="form-select" required>
                            @foreach ($subSubCategories as $subSubCategory)
                                <option value="{{ $subSubCategory->id }}">{{ $subSubCategory->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Вопрос</label>
                        <input type="text" name="question" class="form-control" required maxlength="1000"
                            placeholder="Введите вопрос">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ответ</label>
                        <textarea name="answer" class="form-control" rows="6" placeholder="Введите ответ (опционально)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Порядок (число)</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                        <small class="form-hint">Меньшее значение — выше в списке.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Edit FAQ --}}
    <div class="modal fade" id="faqEditModal" tabindex="-1" aria-labelledby="faqEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="faqEditForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="faqEditModalLabel">Редактировать вопрос</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="faq_id" id="faq-edit-id" value="">
                    <div class="mb-3">
                        <label class="form-label">Подподкатегория</label>
                        <select name="sub_sub_category_id" id="faq-edit-sub-sub-category" class="form-select" required>
                            @foreach ($subSubCategories as $subSubCategory)
                                <option value="{{ $subSubCategory->id }}">{{ $subSubCategory->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Вопрос</label>
                        <input type="text" name="question" id="faq-edit-question" class="form-control" required
                            maxlength="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ответ</label>
                        <textarea name="answer" id="faq-edit-answer" class="form-control" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Порядок (число)</label>
                        <input type="number" name="sort_order" id="faq-edit-sort" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-edit-faq').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const id = btn.dataset.faqId;
                        const question = btn.dataset.faqQuestion || '';
                        const answer = btn.dataset.faqAnswer || '';
                        const sort = btn.dataset.faqSort || 0;
                        const action = btn.dataset.action;

                        const modal = document.getElementById('faqEditModal');
                        const form = document.getElementById('faqEditForm');

                        form.action = action;
                        document.getElementById('faq-edit-id').value = id;
                        document.getElementById('faq-edit-question').value = question;
                        document.getElementById('faq-edit-answer').value = answer;
                        document.getElementById('faq-edit-sort').value = sort;

                        // подставляем подподкатегорию
                        const select = document.getElementById('faq-edit-sub-sub-category');
                        select.value = btn.closest('tr').querySelector('td:nth-child(2)').dataset
                            .subSubCategoryId;

                        const bsModal = new bootstrap.Modal(modal);
                        bsModal.show();
                    });
                });
            });
        </script>
    @endpush

@endsection
