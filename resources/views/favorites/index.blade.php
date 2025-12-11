@extends('layouts.app')

@section('title', 'Мои избранные заявки')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Мои избранные заявки</h2>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($favorites->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($favorites as $favorite)
                            <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
                                <a href="{{ route('applications.show', $favorite->id) }}" style="text-decoration: none; color: inherit; width: 100%; max-width: 420px;">
                                    <div class="card h-100 shadow-sm" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title mb-0">{{ $favorite->address }}</h5>
                                                <form action="{{ route('favorites.remove', $favorite->id) }}" method="POST" style="display: inline;" onclick="event.stopPropagation();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Удалить из избранного">
                                                        <i class="bi bi-star-fill"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $favorite->address ?? 'Нет адреса' }}
                                                </small>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small><strong>Цена:</strong> {{ $favorite->price ? number_format($favorite->price, 0, ',', ' ') . ' ₽' : 'Не указана' }}</small>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge bg-success">{{ $favorite->status?->status ?? 'Нет статуса' }}</span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <small><strong>Комнат:</strong> {{ $favorite->count_rooms ?? 'Не указано' }}</small>
                                                </div>
                                            </div>

                                            <small class="text-muted d-block">
                                                <i class="bi bi-calendar"></i>
                                                {{ $favorite->created_at->format('d.m.Y') }}
                                            </small>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="text-center">
                                                <small class="text-primary">Нажмите для просмотра →</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $favorites->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <p>Избранные заявки отсутствуют</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Перейти к заявкам</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
