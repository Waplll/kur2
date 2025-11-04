@extends('layouts.app')

@section('title', 'Просмотр отзыва')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="card-title mb-3">{{ $review->user->name ?? 'Аноним' }}</h2>
                                <div class="mb-3">
                                    <span class="badge bg-warning text-dark" style="font-size: 16px;">
                                        {{ str_repeat('⭐', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                        {{ $review->rating }}/5
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i>
                                    {{ $review->created_at->format('d.m.Y H:i') }}
                                </small>
                                @if($review->updated_at !== $review->created_at)
                                    <small class="text-muted d-block">
                                        <i class="bi bi-pencil"></i>
                                        Изменено: {{ $review->updated_at->format('d.m.Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <div class="card-text mb-4">
                            <p style="white-space: pre-wrap; word-wrap: break-word;">{{ $review->description }}</p>
                        </div>

                        @if(Auth::check() && (Auth::id() === $review->user_id || Auth::user()->isAdmin()))
                            <div class="d-flex gap-2">
                                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить отзыв?')">
                                        <i class="bi bi-trash"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Вернуться к отзывам
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
