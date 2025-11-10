<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/js/recording-form.js', 'resources/css/recording.css', 'resources/css/price-list.css', 'resources/js/price-list.js', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container ">
                {{ Breadcrumbs::render('price-list') }}
                <div class="title mt-5">
                    Прайс-лист
                </div>
                <div class="desc">
                    Занимайтесь один раз в неделю или каждый день, выбирайте подходящий абонемент и записывайтесь на
                    занятия.
                </div>
            </div>
        </div>
        <div class="price-list">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center btn-container mt-5" id="categoryButtons">
                    @foreach ($categories as $index => $category)
                        <button class="category-btn {{ $index === 0 ? 'active' : 'inactive' }}"
                            data-target="content-{{ $category->slug }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- ТЕКСТЫ — ВСЁ В HTML -->
                @foreach ($categories as $index => $category)
                    <div id="content-{{ $category->slug }}" class="content-text {{ $index === 0 ? 'active' : '' }}">
                        @foreach ($category->tables as $table)
                            <table class="custom-table">
                                <tr class="table-title-row">
                                    <td colspan="2" class="table-title">{{ $table->title }}</td>
                                </tr>
                                @foreach ($table->items as $item)
                                    <tr class="table-item-row">
                                        <td class="table-item-name">{{ $item->name }}</td>
                                        <td class="table-item-info">
                                            <div class="table-item-duration">{{ $item->duration }} мин</div>
                                            <div class="table-item-price">{{ $item->price }} ₽</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mb-5">
        @include('partials.recording-block')
    </div>
    @include('partials.footer')

</body>

</html>
