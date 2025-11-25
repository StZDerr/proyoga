@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Просмотр компании: {{ $company->name }}</h2>
            <div>
                <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-sm btn-warning">Редактировать</a>

                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить компанию?')">Удалить</button>
                </form>

                <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-outline-secondary ms-2">К списку</a>
            </div>
        </div>

        @include('admin.partials.success')

        <div class="card">
            <div class="card-body">
                <h4>{{ $company->name }}</h4>
                <p><strong>Категория:</strong> {{ $company->category ?? '—' }}</p>
                <p><strong>Телефон:</strong> {{ $company->phone ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $company->email ?? '—' }}</p>

                <div class="mb-3">
                    <h5>Преимущества / Описание</h5>
                    <div>{!! nl2br(e($company->advantages ?? '—')) !!}</div>
                </div>

                <div class="mb-3">
                    <h5>Соцсети</h5>

                    @if (!empty($socials))
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($socials as $key => $link)
                                @php
                                    $link = trim((string) $link);
                                    if ($link === '') {
                                        continue;
                                    }
                                    if (!preg_match('#^https?://#i', $link)) {
                                        $link = 'https://' . $link;
                                    }
                                    $slug = \Illuminate\Support\Str::slug($key);
                                    $iconPath = public_path("images/svg/{$slug}.svg");
                                    $iconUrl = file_exists($iconPath)
                                        ? asset("images/svg/{$slug}.svg")
                                        : asset('images/svg/link.svg');
                                    $label = ucfirst(str_replace(['-', '_'], ' ', $key));
                                @endphp

                                <a href="{{ $link }}" target="_blank" rel="noopener" class="socialItem"
                                    title="{{ $label }}">
                                    <img src="{{ $iconUrl }}" alt="{{ $label }}" width="28" height="28"
                                        loading="lazy">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div>—</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
