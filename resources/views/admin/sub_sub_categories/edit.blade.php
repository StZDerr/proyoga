@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать подподкатегорию</h2>

        @include('admin.partials.success')

        <form action="{{ route('admin.sub-sub-categories.update', $subSubCategory) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $subSubCategory->title) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ old('description', $subSubCategory->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">О программе</label>
                <textarea name="about" class="form-control">{{ old('about', $subSubCategory->about) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Изображение (webp, макс. 2МБ)</label>
                <input type="file" name="image" class="form-control">
                @if ($subSubCategory->image)
                    <img src="{{ asset('storage/' . $subSubCategory->image) }}" alt="{{ $subSubCategory->title }}"
                        width="100" class="mt-2">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Группы преимуществ</label>
                <div id="benefit-groups-container">
                    @php
                        $benefitGroups = old('benefit_groups', $subSubCategory->benefits ?? []);
                        $benefitGroups = is_array($benefitGroups) ? $benefitGroups : [];
                    @endphp

                    @if (count($benefitGroups) > 0)
                        @foreach ($benefitGroups as $groupIndex => $group)
                            <div class="benefit-group border p-3 mb-3" data-group-index="{{ $groupIndex }}">
                                <div class="mb-2">
                                    <label class="form-label">Название группы</label>
                                    <input type="text" name="benefit_groups[{{ $groupIndex }}][title]"
                                        class="form-control" value="{{ $group['title'] ?? '' }}"
                                        placeholder="Например: Для начинающих">
                                </div>
                                <div class="benefits-container">
                                    <label class="form-label">Преимущества</label>
                                    @if (isset($group['benefits']) && is_array($group['benefits']))
                                        @foreach ($group['benefits'] as $benefit)
                                            <input type="text" name="benefit_groups[{{ $groupIndex }}][benefits][]"
                                                class="form-control mb-2" value="{{ $benefit }}"
                                                placeholder="Преимущество">
                                        @endforeach
                                    @else
                                        <input type="text" name="benefit_groups[{{ $groupIndex }}][benefits][]"
                                            class="form-control mb-2" placeholder="Преимущество">
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary me-2"
                                    onclick="addBenefit(this)">+ Добавить преимущество</button>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="removeBenefitGroup(this)">Удалить группу</button>
                            </div>
                        @endforeach
                    @else
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
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addBenefitGroup()">+ Добавить группу
                    преимуществ</button>
            </div>

            <div class="mb-3">
                <label class="form-label">Подкатегория</label>
                <select name="sub_category_id" class="form-select" required>
                    @foreach ($subCategories as $sub)
                        <option value="{{ $sub->id }}" @if ($sub->id == $subSubCategory->sub_category_id) selected @endif>
                            {{ $sub->title }} ({{ $sub->mainCategory->title }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

    <script>
        let groupIndex = {{ count($benefitGroups) }};

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
