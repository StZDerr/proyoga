@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить подподкатегорию</h2>

        @include('admin.partials.success')

        <form action="{{ route('admin.sub-sub-categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            {{-- О "Названии" --}}
            <div class="mb-3">
                <label class="form-label">О "Названии"</label>
                <input type="text" name="about_title" class="form-control" value="{{ old('about_title') }}" required>
            </div>

            {{-- Польза "Название" --}}
            <div class="mb-3">
                <label class="form-label">Польза "Название"</label>
                <input type="text" name="benefit_title" class="form-control" value="{{ old('benefit_title') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">О программе</label>
                <textarea name="about" class="form-control">{{ old('about') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Изображение (webp, макс. 2МБ)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Фотографии (webp, макс. 2 МБ каждая)</label>
                <input type="file" name="photos[]" class="form-control" multiple accept=".webp">
                <small class="text-muted">Можно выбрать несколько файлов сразу</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Группы преимуществ</label>
                <div id="benefit-groups-container">
                    <div class="benefit-group border p-3 mb-3" data-group-index="0">
                        <div class="mb-2">
                            <label class="form-label">Название группы</label>
                            <input type="text" name="benefit_groups[0][title]" class="form-control"
                                placeholder="Например: Для начинающих">
                        </div>
                        <div class="benefits-container">
                            <label class="form-label">Преимущества</label>
                            <input type="text" name="benefit_groups[0][benefits][]" class="form-control mb-2"
                                placeholder="Преимущество">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="addBenefit(this)">+
                            Добавить преимущество</button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="removeBenefitGroup(this)">Удалить группу</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addBenefitGroup()">+ Добавить группу
                    преимуществ</button>
            </div>

            <div class="mb-3">
                <label class="form-label">Подкатегория</label>
                <select name="sub_category_id" class="form-select" required>
                    <option value="">Выберите подкатегорию</option>
                    @foreach ($subCategories as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->title }} ({{ $sub->mainCategory->title }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

    <script>
        let groupIndex = 1;

        function addBenefitGroup() {
            const container = document.getElementById('benefit-groups-container');
            const groupDiv = document.createElement('div');
            groupDiv.className = 'benefit-group border p-3 mb-3';
            groupDiv.setAttribute('data-group-index', groupIndex);

            groupDiv.innerHTML = `
                <div class="mb-2">
                    <label class="form-label">Название группы</label>
                    <input type="text" name="benefit_groups[${groupIndex}][title]" class="form-control" placeholder="Например: Для начинающих">
                </div>
                <div class="benefits-container">
                    <label class="form-label">Преимущества</label>
                    <input type="text" name="benefit_groups[${groupIndex}][benefits][]" class="form-control mb-2" placeholder="Преимущество">
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="addBenefit(this)">+ Добавить преимущество</button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeBenefitGroup(this)">Удалить группу</button>
            `;

            container.appendChild(groupDiv);
            groupIndex++;
        }

        function addBenefit(button) {
            const benefitsContainer = button.closest('.benefit-group').querySelector('.benefits-container');
            const groupIndex = button.closest('.benefit-group').getAttribute('data-group-index');

            const input = document.createElement('input');
            input.type = 'text';
            input.name = `benefit_groups[${groupIndex}][benefits][]`;
            input.className = 'form-control mb-2';
            input.placeholder = 'Преимущество';

            benefitsContainer.appendChild(input);
        }

        function removeBenefitGroup(button) {
            const groupsContainer = document.getElementById('benefit-groups-container');
            if (groupsContainer.children.length > 1) {
                button.closest('.benefit-group').remove();
            } else {
                alert('Должна остаться хотя бы одна группа преимуществ');
            }
        }
    </script>
@endsection
