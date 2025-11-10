<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.seo-meta')
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/direction.css', 'resources/css/arrow.css', 'resources/js/arrow.js', 'resources/css/cookies.css', 'resources/js/cookies.js'])
</head>

<body>

    @include('partials.navbar')
    @include('partials.arrow')
    @include('partials.cookies')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container ">
                {{ Breadcrumbs::render('PodDirection', $subCategory) }}
                <div class="title mt-5">
                    {{ $subCategory->title }}
                </div>
                <div class="desc">
                    {{ $subCategory->description ?? 'Описание направления' }}
                </div>

                @if ($subCategory->subSubCategories->count() > 0)
                    <div class="directions">
                        <div class="container">
                            <div class="row g-4 main-directions mt-2">
                                @foreach ($subCategory->subSubCategories as $subSubCategory)
                                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                                        <a href="{{ route('subSubCategoryDetail', [$subCategory->slug, $subSubCategory->slug]) }}"
                                            class="text-decoration-none text-dark">
                                            <div class="card-directions">
                                                @if ($subSubCategory->image)
                                                    <img src="{{ asset('storage/' . $subSubCategory->image) }}"
                                                        alt="{{ $subSubCategory->title }}" />
                                                @else
                                                    <img src="{{ asset('images/directions-background.webp') }}"
                                                        alt="directions-background" />
                                                @endif
                                                <div class="d-flex justify-content-between p-3">
                                                    <div class="title">
                                                        {{ $subSubCategory->title }}
                                                    </div>
                                                    <div class="arrow">
                                                        <i class="bi bi-arrow-right fs-4"></i>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    {{ $subSubCategory->description ?? 'Описание направления' }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4">В данной категории пока нет подкатегорий.</p>
                @endif
            </div>
        </div>
    </div>
    @include('partials.footer')

</body>

</html>
