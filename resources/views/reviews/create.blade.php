@extends('layouts.app')

@section('title', 'Написать отзыв')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Написать отзыв</h2>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Ошибка:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf

                    <!-- Оценка -->
                    <div class="mb-4">
                        <label class="form-label"><strong>Оценка <span class="text-danger">*</span></strong></label>
                        <div class="star-rating mb-3">
                            <input type="hidden" id="rating-value" name="rating" value="{{ old('rating', 5) }}">

                            <div class="d-flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            class="star-btn btn btn-lg"
                                            data-rating="{{ $i }}"
                                            style="background: none; border: none; font-size: 50px; cursor: pointer; color: #ffc107; padding: 0;">
                                        ⭐
                                    </button>
                                @endfor
                            </div>

                            <div class="mt-3">
                                <span id="rating-text" style="font-size: 18px; font-weight: bold; color: #ffc107;">
                                    {{ old('rating', 5) }} из 5 звёзд
                                </span>
                            </div>
                        </div>
                        @error('rating')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Текст отзыва -->
                    <div class="mb-4">
                        <label for="description" class="form-label"><strong>Ваш отзыв <span class="text-danger">*</span></strong></label>
                        <textarea name="description" id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="8" placeholder="Поделитесь своим мнением... (минимум 10 символов)"
                                  required>{{ old('description') }}</textarea>
                        <small class="form-text text-muted d-block mt-2">
                            Минимум 10 символов, максимум 1000 символов
                        </small>
                        @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <small class="text-muted">Символов: <span id="char-count">0</span>/1000</small>
                        </div>
                    </div>

                    <!-- Кнопки -->
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Отмена</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Опубликовать отзыв
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Рейтинг
        const ratingValue = document.getElementById('rating-value');
        const ratingText = document.getElementById('rating-text');
        const starBtns = document.querySelectorAll('.star-btn');

        starBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const rating = this.getAttribute('data-rating');
                ratingValue.value = rating;
                ratingText.textContent = rating + ' из 5 звёзд';
                updateStars();
            });
        });

        function updateStars() {
            const rating = ratingValue.value;
            starBtns.forEach((btn, index) => {
                if (index < rating) {
                    btn.textContent = '⭐';
                } else {
                    btn.textContent = '☆';
                }
            });
        }

        // Инициализировать звёзды при загрузке
        updateStars();

        // Счётчик символов
        const description = document.getElementById('description');
        const charCount = document.getElementById('char-count');

        description.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        charCount.textContent = description.value.length;
    </script>

    <style>
        .star-btn {
            transition: transform 0.2s;
        }

        .star-btn:hover {
            transform: scale(1.2);
        }

        .star-btn:active {
            transform: scale(0.95);
        }
    </style>
@endsection
