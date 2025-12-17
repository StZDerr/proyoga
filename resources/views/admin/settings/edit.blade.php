@extends('admin.layouts.app')

@section('title', 'Настройки сайта — Логотипы и favicon')

@section('content')
    <div class="container">
        <h1 class="mb-4">Настройки сайта — Логотипы и favicon</h1>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="card p-4">
            @csrf
            @method('PUT')

            <div class="row mb-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Логотип (navbar)</label>
                    <div class="mb-2">
                        @if ($setting->navbar_logo_url ?? $setting->logo_navbar)
                            <img src="{{ $setting->navbar_logo_url ?? asset('storage/' . $setting->logo_navbar) }}"
                                alt="Navbar logo" style="max-height:80px; max-width:100%;">
                        @else
                            <div class="text-muted">нет изображения</div>
                        @endif
                    </div>
                    <input type="file" name="logo_navbar" accept=".svg,image/svg+xml,.webp,image/webp"
                        class="form-control">
                    <small class="text-muted">Макс. 200кб. Загрузка заменит существующий логотип.</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Логотип (footer)</label>
                    <div class="mb-2">
                        @if ($setting->footer_logo_url ?? $setting->logo_footer)
                            <img src="{{ $setting->footer_logo_url ?? asset('storage/' . $setting->logo_footer) }}"
                                alt="Footer logo" style="max-height:80px; max-width:100%;">
                        @else
                            <div class="text-muted">нет изображения</div>
                        @endif
                    </div>
                    <input type="file" name="logo_footer" accept=".svg,image/svg+xml,.webp,image/webp"
                        class="form-control">
                    <small class="text-muted">Макс. 200кб. Загрузка заменит существующий логотип.</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Favicon</label>
                    <div class="mb-2">
                        @if ($setting->favicon_url ?? $setting->favicon)
                            <img src="{{ $setting->favicon_url ?? asset('storage/' . $setting->favicon) }}" alt="Favicon"
                                style="height:48px; width:auto;">
                        @else
                            <div class="text-muted">нет изображения</div>
                        @endif
                    </div>
                    <input type="file" name="favicon" accept=".svg,image/svg+xml,.webp,image/webp" class="form-control">
                    <small class="text-muted">Рекомендуемый размер: 32×32. Макс. 200кб.</small>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Отмена</a>
            </div>
        </form>
    </div>

    <!-- Небольшой JS: предпросмотр выбранных изображений -->
    @push('scripts')
        <script>
            document.addEventListener('change', function(e) {
                if (!e.target.matches('input[type="file"]')) return;
                const input = e.target;
                if (!input.files || !input.files[0]) return;
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.maxHeight = '80px';
                    img.style.maxWidth = '100%';
                    // вставляем превью рядом с инпутом (заменяем старое превью)
                    const container = input.previousElementSibling;
                    if (container && container.tagName === 'DIV') {
                        container.innerHTML = '';
                        container.appendChild(img);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            });
        </script>
    @endpush
@endsection
