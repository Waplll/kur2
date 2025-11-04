<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Показать все отзывы
     */
    public function index()
    {
        $reviews = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Показать форму создания отзыва
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Сохранить новый отзыв
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Укажите оценку',
            'rating.integer' => 'Оценка должна быть числом',
            'rating.min' => 'Оценка должна быть минимум 1',
            'rating.max' => 'Оценка должна быть максимум 5',
            'description.required' => 'Введите текст отзыва',
            'description.min' => 'Отзыв должен содержать минимум 10 символов',
            'description.max' => 'Отзыв не должен превышать 1000 символов',
        ]);

        $validated['user_id'] = Auth::id();

        Review::create($validated);

        return redirect()->route('reviews.index')->with('success', 'Ваш отзыв успешно добавлен!');
    }

    /**
     * Показать отзыв
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Показать форму редактирования отзыва
     */
    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Вы не можете редактировать этот отзыв');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Обновить отзыв
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Вы не можете редактировать этот отзыв');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Укажите оценку',
            'rating.integer' => 'Оценка должна быть числом',
            'rating.min' => 'Оценка должна быть минимум 1',
            'rating.max' => 'Оценка должна быть максимум 5',
            'description.required' => 'Введите текст отзыва',
            'description.min' => 'Отзыв должен содержать минимум 10 символов',
            'description.max' => 'Отзыв не должен превышать 1000 символов',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.index')->with('success', 'Отзыв успешно обновлен!');
    }

    /**
     * Удалить отзыв
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Вы не можете удалить этот отзыв');
        }

        $review->delete();

        return back()->with('success', 'Отзыв удалён!');
    }
}
