@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать сегмент</h2>

        {{-- @include('admin.partials.errors') --}}

        <form action="{{ route('admin.spins.update', $spin) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.spins._form', ['spin' => $spin])

            <button type="submit" class="btn btn-primary mt-3">Сохранить</button>
        </form>
    </div>
@endsection
