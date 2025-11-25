@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать подподкатегорию</h2>

        @include('admin.partials.success')

        <form action="{{ route('admin.sub-sub-categories.update', $subSubCategory) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Название --}}
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $subSubCategory->title) }}"
                    required>
            </div>

            {{-- О "Названии" --}}
            <div class="mb-3">
                <label class="form-label">О "Названии"</label>
                <input type="text" name="about_title" class="form-control"
                    value="{{ old('about_title', $subSubCategory->about_title) }}" required>
            </div>

            {{-- Польза "Название" --}}
            <div class="mb-3">
                <label class="form-label">Польза "Название"</label>
                <input type="text" name="benefit_title" class="form-control"
                    value="{{ old('benefit_title', $subSubCategory->benefit_title) }}" required>
            </div>

            {{-- Описание --}}
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ old('description', $subSubCategory->description) }}</textarea>
            </div>

            {{-- О программе --}}
            <div class="mb-3">
                <label class="form-label">О программе</label>
                <textarea name="about" class="form-control">{{ old('about', $subSubCategory->about) }}</textarea>
            </div>

            {{-- Основное изображение --}}
            <div class="mb-3">
                <label class="form-label">Изображение (webp, макс. 2МБ)</label>
                <input type="file" name="image" class="form-control" accept=".webp">
                @if ($subSubCategory->image)
                    <img src="{{ asset('storage/' . $subSubCategory->image) }}" alt="{{ $subSubCategory->title }}"
                        width="100" class="mt-2">
                @endif
            </div>

            {{-- Множественные фотографии --}}
            <div class="mb-3">
                <label class="form-label">Фотографии (webp, макс. 2МБ каждая)</label>
                <input type="file" name="photos[]" class="form-control mb-2" multiple accept=".webp">
                @if ($subSubCategory->photos->count())
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach ($subSubCategory->photos as $photo)
                            <div class="position-relative photo-thumb">
                                <img src="{{ asset('storage/' . $photo->image) }}" width="100" class="border">
                                <button type="button"
                                    class="btn btn-sm btn-danger delete-photo-btn position-absolute top-0 end-0 m-0 p-0"
                                    style="font-size: 0.7rem; z-index: 10;"
                                    data-action="{{ route('admin.sub-sub-categories.photos.destroy', $photo) }}">×</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Группы преимуществ --}}
            <div class="mb-3">
                <label class="form-label">Группы преимуществ</label>
                <div id="benefit-groups-container">
                    @php
                        $benefitGroups = old('benefit_groups', $subSubCategory->benefits ?? []);
                        $benefitGroups = is_array($benefitGroups) ? $benefitGroups : [];
                    @endphp

                    @if (count($benefitGroups))
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

            {{-- Подкатегория --}}
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

        // AJAX delete for photos to avoid nested forms inside the main form
        document.addEventListener('click', function(e) {
            if (!e.target.matches('.delete-photo-btn')) return;

            if (!confirm('Удалить фотографию?')) {
                return;
            }

            const btn = e.target;
            const action = btn.dataset.action;
            if (!action) return;

            btn.disabled = true;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch(action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) return response.json().catch(() => ({}));
                    throw new Error('Network error');
                })
                .then(() => {
                    const photoWrapper = btn.closest('.photo-thumb');
                    if (photoWrapper) photoWrapper.remove();
                })
                .catch((err) => {
                    console.error(err);
                    alert('Не удалось удалить фото. Обновите страницу и попробуйте снова.');
                    btn.disabled = false;
                });
        });
    </script>
@endsection
