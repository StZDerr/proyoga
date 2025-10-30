<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПроЙога</title>
    @include('partials.favicon')

    {{-- Общие стили и JS через Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/navbar.css', 'resources/css/footer.css', 'resources/js/navbar.js', 'resources/css/direction.css'])
</head>

<body>

    @include('partials.navbar')
    <div class="background-gor">
        <div class="headerTeaZone mt-5">
            <div class="container ">
                {{ Breadcrumbs::render('direction') }}
                <div class="title mt-5">
                    Направления занятий
                </div>
                <div class="desc">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa voluptatum, facilis
                    accusamus explicabo nihil deserunt minus odit molestiae dolore quis.
                </div>
                @foreach ($mainCategories as $mainCategory)
                    <div class="title-direction mt-5">
                        {{ $mainCategory->title }}
                    </div>

                    @if ($mainCategory->subCategories->count() > 0)
                        <div class="directions">
                            <div class="container">
                                <div class="row g-4 main-directions mt-2">
                                    @foreach ($mainCategory->subCategories as $subCategory)
                                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                                            <a href="{{ route('PodDirection', $subCategory->id) }}"
                                                class="text-decoration-none text-dark">
                                                <div class="card-directions">
                                                    @if ($subCategory->image)
                                                        <img src="{{ asset('storage/' . $subCategory->image) }}"
                                                            alt="{{ $subCategory->title }}" />
                                                    @else
                                                        <img src="{{ asset('images/directions-background.webp') }}"
                                                            alt="directions-background" />
                                                    @endif
                                                    <div class="d-flex justify-content-between p-3">
                                                        <div class="title">
                                                            {{ $subCategory->title }}
                                                        </div>
                                                        <div class="arrow">
                                                            <i class="bi bi-arrow-right fs-4"></i>
                                                        </div>
                                                    </div>
                                                    <div class="text">
                                                        {{ $subCategory->description ?? 'Описание направления' }}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @include('partials.footer')

</body>

</html>
