@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h2>Компании (Taplink)</h2>
            <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">Добавить компанию</a>
        </div>

        @include('admin.partials.success')

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Фотография</th>
                        <th>Преимущества</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Соцсети</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->category ?? '—' }}</td>
                            <td>
                                @if ($company->photo && file_exists(public_path('images/companies/' . $company->photo)))
                                    <a href="{{ asset('images/companies/' . $company->photo) }}" target="_blank"
                                        rel="noopener">
                                        <img src="{{ asset('images/companies/' . $company->photo) }}"
                                            alt="{{ $company->name ?? 'company' }}"
                                            style="max-width:100px; height:auto; display:block;">
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            @php
                                $advantages = $company->advantages ?? '';

                                // Разбиваем по переводам строк или запятым, очищаем пробелы и пустые элементы
                                $parts = preg_split('/\r\n|\r|\n|\s*,\s*/u', $advantages);
                                $parts = array_filter(array_map('trim', $parts));

                                // Собираем в одну строку с переводами строк между пунктами
                                $display = implode("\n", $parts);

                                // Обрезаем итоговую строку (160 символов)
                                $display = \Illuminate\Support\Str::limit($display, 160);
                            @endphp

                            <td style="max-width: 320px;">
                                {!! nl2br(e($display)) !!}
                            </td>
                            <td>{{ $company->phone ?? '—' }}</td>
                            <td>{{ $company->email ?? '—' }}</td>
                            <td style="min-width: 140px;">
                                @if (!empty($company->socials) && is_array($company->socials))
                                    @foreach ($company->socials as $key => $link)
                                        @if ($link)
                                            <a href="{{ $link }}" target="_blank" rel="noopener" class="me-2 small">
                                                {{ ucfirst($key) }}
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.companies.show', $company->id) }}"
                                    class="btn btn-sm btn-info">Просмотр</a>
                                <a href="{{ route('admin.companies.edit', $company->id) }}"
                                    class="btn btn-sm btn-warning">Редактировать</a>

                                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить компанию?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Компаний пока нет</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (method_exists($companies, 'links'))
            <div class="mt-3">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
@endsection
