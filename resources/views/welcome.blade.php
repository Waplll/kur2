@extends('layouts.app')

@section('title', 'Добро пожаловать!')

@section('content')
    <div class="mt-4">
        <h1 class="mb-4 text-center">Добро пожаловать в систему недвижимости!</h1>

        @auth
            <div class="alert alert-success text-center">
                <h5>Привет, {{ Auth::user()->name }}!</h5>
                <p>Вы авторизованы в системе. Используйте меню для навигации.</p>
            </div>
        @endauth

        <div class="row justify-content-center mt-5">
            <div class="col-md-8 text-center mb-4">
                <p class="lead">Актуальные одобренные заявки на объекты недвижимости:</p>
            </div>
        </div>

        <div class="row">
            @forelse($applications as $app)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow">
                        @if ($app->path_image)
                            <img src="{{ asset('storage/' . $app->path_image) }}" class="card-img-top" alt="Фото" style="object-fit: cover; max-height: 220px;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $app->address }}</h5>
                            <p class="card-text">
                                <strong>Комнат:</strong> {{ $app->count_rooms }}<br>
                                <strong>Цена:</strong> {{ number_format($app->price, 0, ',', ' ') }} руб.<br>
                                <strong>Тип:</strong> {{ $app->typeBuy->type_buy ?? '—' }}<br>
                                <strong>Пользователь:</strong> {{ $app->user->name ?? '—' }}
                                <br>
                                <span class="badge bg-success">Одобрена</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">Пока нет одобренных заявок!</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
