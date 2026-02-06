@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Добавить сегмент</h2>

        {{-- @include('admin.partials.errors') --}}

        <form action="{{ route('admin.spins.store') }}" method="POST">
            @csrf

            @include('admin.spins._form', ['spin' => null])

            <button type="submit" class="btn btn-primary mt-3">Создать</button>
        </form>
    </div>
@endsection
