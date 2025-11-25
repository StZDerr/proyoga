@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Редактировать компанию: {{ $company->name }}</h2>
            <a href="{{ route('admin.companies.index') }}" class="btn btn-outline-secondary">Назад к списку</a>
        </div>

        @include('admin.partials.success')

        <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Название <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $company->name) }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Категория</label>
                <input type="text" name="category" value="{{ old('category', $company->category) }}"
                    class="form-control @error('category') is-invalid @enderror">
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Фото компании</label>
                <div class="d-flex align-items-center gap-3">
                    <input type="file" name="photo" id="company-photo" accept="image/*"
                        class="form-control form-control-sm @error('photo') is-invalid @enderror" />
                    <div id="company-photo-preview" style="max-width:140px;">

                        @php
                            $photoPath = $company->photo ? public_path('images/companies/' . $company->photo) : null;
                        @endphp

                        @if ($company->photo && $photoPath && file_exists($photoPath))
                            <a href="{{ asset('images/companies/' . $company->photo) }}" target="_blank" rel="noopener">
                                <img src="{{ asset('images/companies/' . $company->photo) }}"
                                    alt="{{ $company->name ?? 'company' }}"
                                    style="max-width:140px; height:auto; display:block;">
                            </a>
                        @endif
                    </div>
                </div>
                @error('photo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <div class="small text-muted mt-1">Рекомендуемый размер: 150кб, webp.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Преимущества / Описание</label>
                <textarea name="advantages" rows="5" class="form-control @error('advantages') is-invalid @enderror">{{ old('advantages', $company->advantages) }}</textarea>
                @error('advantages')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $company->phone) }}"
                        class="form-control @error('phone') is-invalid @enderror" placeholder="+7 (___) ___-__-__">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Socials -->
            <div class="mb-3">
                <label class="form-label">Соцсети / Ссылки</label>
                <p class="small text-muted">
                    Укажите ключ (название соцсети), ссылку и при желании загрузите иконку (SVG). Иконки сохраняются в
                    <code>public/images/svg/{ключ}.svg</code>.
                </p>

                <div id="socials-list">
                    @php
                        // Приоритет: old -> company->socials -> пустой набор (предустановленные)
                        $initialSocials = old('socials', $company->socials ?? []);
                    @endphp

                    @if (is_array($initialSocials) && count($initialSocials))
                        @foreach ($initialSocials as $key => $value)
                            @php
                                $slug = \Illuminate\Support\Str::slug($key);
                                $iconPath = public_path("images/svg/{$slug}.svg");
                            @endphp
                            <div class="d-flex mb-2 social-row align-items-center">
                                <input type="text" class="form-control me-2" placeholder="ключ (например instagram)"
                                    value="{{ $key }}" readonly style="max-width:150px;">
                                <input type="url" class="form-control me-2" name="socials[{{ $key }}]"
                                    value="{{ $value }}" placeholder="https://...">
                                <input type="file" class="form-control form-control-sm me-2"
                                    name="social_icons[{{ $key }}]" accept=".svg" style="max-width:220px;">
                                @if (file_exists($iconPath))
                                    <img src="{{ asset("images/svg/{$slug}.svg") }}" alt="{{ $key }}"
                                        width="28" height="28" class="me-2">
                                @endif
                                <button type="button" class="btn btn-danger btn-sm remove-social">×</button>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex mb-2 social-row">
                            <input type="text" class="form-control me-2" value="instagram" readonly
                                style="max-width:150px;">
                            <input type="url" class="form-control me-2" name="socials[instagram]"
                                value="{{ old('socials.instagram') }}" placeholder="https://instagram.com/...">
                            <input type="file" class="form-control form-control-sm me-2"
                                name="social_icons[instagram]" accept=".svg" style="max-width:220px;">
                            <button type="button" class="btn btn-danger btn-sm remove-social">×</button>
                        </div>
                        <div class="d-flex mb-2 social-row">
                            <input type="text" class="form-control me-2" value="telegram" readonly
                                style="max-width:150px;">
                            <input type="url" class="form-control me-2" name="socials[telegram]"
                                value="{{ old('socials.telegram') }}" placeholder="https://t.me/...">
                            <input type="file" class="form-control form-control-sm me-2" name="social_icons[telegram]"
                                accept=".svg" style="max-width:220px;">
                            <button type="button" class="btn btn-danger btn-sm remove-social">×</button>
                        </div>
                        <div class="d-flex mb-2 social-row">
                            <input type="text" class="form-control me-2" value="vk" readonly
                                style="max-width:150px;">
                            <input type="url" class="form-control me-2" name="socials[vk]"
                                value="{{ old('socials.vk') }}" placeholder="https://vk.com/...">
                            <input type="file" class="form-control form-control-sm me-2" name="social_icons[vk]"
                                accept=".svg" style="max-width:220px;">
                            <button type="button" class="btn btn-danger btn-sm remove-social">×</button>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2 mt-2">
                    <input id="new-social-key" type="text" class="form-control"
                        placeholder="ключ (например website)">
                    <input id="new-social-url" type="url" class="form-control" placeholder="https://...">
                    <input id="new-social-icon" type="file" class="form-control" accept=".svg">
                    <button id="add-social" type="button" class="btn btn-outline-primary">Добавить</button>
                </div>

                @if ($errors->has('socials'))
                    <div class="text-danger small mt-1">{{ $errors->first('socials') }}</div>
                @endif
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary ms-2">Отмена</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                const socialsList = document.getElementById('socials-list');
                const addBtn = document.getElementById('add-social');
                const keyInput = document.getElementById('new-social-key');
                const urlInput = document.getElementById('new-social-url');
                const iconInput = document.getElementById('new-social-icon');

                function slugify(text) {
                    return text.toString().toLowerCase().trim()
                        .replace(/\s+/g, '-') // Replace spaces with -
                        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                        .replace(/\-\-+/g, '-') // Replace multiple - with single -
                        .replace(/^-+/, '') // Trim - from start of text
                        .replace(/-+$/, ''); // Trim - from end of text
                }

                function createRow(key, url) {
                    const row = document.createElement('div');
                    row.className = 'd-flex mb-2 social-row';
                    row.style.alignItems = 'center';

                    const keyInputView = document.createElement('input');
                    keyInputView.type = 'text';
                    keyInputView.className = 'form-control me-2';
                    keyInputView.value = key;
                    keyInputView.readOnly = true;
                    keyInputView.style.maxWidth = '150px';

                    const urlInputField = document.createElement('input');
                    urlInputField.type = 'url';
                    urlInputField.className = 'form-control me-2';
                    urlInputField.name = 'socials[' + key + ']';
                    urlInputField.placeholder = 'https://...';
                    urlInputField.value = url || '';

                    const fileInputField = document.createElement('input');
                    fileInputField.type = 'file';
                    fileInputField.className = 'form-control form-control-sm me-2';
                    fileInputField.name = 'social_icons[' + key + ']';
                    fileInputField.accept = '.svg';
                    fileInputField.style.maxWidth = '220px';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm remove-social';
                    removeBtn.textContent = '×';
                    removeBtn.addEventListener('click', () => row.remove());

                    row.appendChild(keyInputView);
                    row.appendChild(urlInputField);
                    row.appendChild(fileInputField);
                    row.appendChild(removeBtn);

                    socialsList.appendChild(row);
                }

                addBtn.addEventListener('click', function() {
                    const rawKey = keyInput.value || '';
                    const url = urlInput.value || '';
                    if (!rawKey.trim()) {
                        keyInput.classList.add('is-invalid');
                        setTimeout(() => keyInput.classList.remove('is-invalid'), 1200);
                        return;
                    }
                    const key = slugify(rawKey);
                    // ensure unique name
                    if (document.querySelector('[name="socials[' + key + ']"]')) {
                        keyInput.classList.add('is-invalid');
                        setTimeout(() => keyInput.classList.remove('is-invalid'), 1200);
                        return;
                    }
                    createRow(key, url);
                    keyInput.value = '';
                    urlInput.value = '';
                    iconInput.value = '';
                });

                // delegate remove buttons for rows created from server
                socialsList.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-social')) {
                        const row = e.target.closest('.social-row');
                        if (row) row.remove();
                    }
                });
            })();
            (function() {
                const photoInput = document.getElementById('company-photo');
                const preview = document.getElementById('company-photo-preview');
                if (!photoInput || !preview) return;

                // Сохраним текущее содержимое превью (текущая фотография), чтобы можно было восстановить
                const originalPreviewHtml = preview.innerHTML;

                photoInput.addEventListener('change', function(e) {
                    const file = e.target.files && e.target.files[0];

                    if (!file) {
                        // если файл снят/очищен — вернуть старое превью
                        preview.innerHTML = originalPreviewHtml;
                        return;
                    }

                    // Ограничим размер и тип на клиенте (дополнительно к серверной валидации)
                    if (!file.type.startsWith('image/')) {
                        preview.innerHTML = '<div class="text-danger small">Выберите изображение.</div>';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const src = ev.target.result;
                        preview.innerHTML = '' +
                            '<a href="' + src + '" target="_blank" rel="noopener">' +
                            '<img src="' + src +
                            '" alt="preview" style="max-width:140px; height:auto; display:block;" loading="lazy">' +
                            '</a>';
                    };
                    reader.readAsDataURL(file);
                });
            })();
        </script>
    @endpush
@endsection
