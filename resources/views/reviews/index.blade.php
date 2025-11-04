@extends('layouts.app')

@section('title', 'Отзывы')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Отзывы пользователей</h2>
                    @auth
                        <a href="{{ route('reviews.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Написать отзыв
                        </a>
                    @endauth
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($reviews->count() > 0)
                    <div class="row">
                        @foreach($reviews as $review)
                            <div class="col-md-12 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1">
                                                    {{ $review->user->name ?? 'Аноним' }}
                                                </h5>
                                                <div class="mb-2">
                                                    <span class="badge bg-warning text-dark">
                                                        {{ str_repeat('⭐', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                                        {{ $review->rating }}/5
                                                    </span>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                {{ $review->created_at->format('d.m.Y H:i') }}
                                            </small>
                                        </div>

                                        <p class="card-text">{{ $review->description }}</p>

                                        @if(Auth::check() && (Auth::id() === $review->user_id || Auth::user()->isAdmin()))
                                            <div class="mt-3">
                                                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> Редактировать
                                                </a>
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить отзыв?')">
                                                        <i class="bi bi-trash"></i> Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <p>Отзывов пока нет.</p>
                        @auth
                            <a href="{{ route('reviews.create') }}" class="btn btn-success">Написать первый отзыв</a>
                        @else
                            <p>
                                <a href="{{ route('login') }}" class="btn btn-primary">Войдите</a> чтобы написать отзыв
                            </p>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
