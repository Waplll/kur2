<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Добавить заявку в избранное
     */
    public function add($applicationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Войдите в систему');
        }

        $application = Application::findOrFail($applicationId);

        // Проверить что ещё не добавлено
        $exists = Favorite::where('user_id', Auth::id())
            ->where('application_id', $applicationId)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id' => Auth::id(),
                'application_id' => $applicationId,
            ]);
            return back()->with('success', 'Заявка добавлена в избранное!');
        }

        return back()->with('info', 'Заявка уже в избранном');
    }

    /**
     * Удалить заявку из избранного
     */
    public function remove($applicationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Favorite::where('user_id', Auth::id())
            ->where('application_id', $applicationId)
            ->delete();

        return back()->with('success', 'Заявка удалена из избранного');
    }

    /**
     * Показать все избранные заявки пользователя
     */
    public function index()
    {
        $favorites = Auth::user()->favoriteApplications()
            ->with(['status', 'typeBuy', 'user'])
            ->orderBy('favorites.created_at', 'desc')
            ->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle - добавить/удалить из избранного
     */
    public function toggle($applicationId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $application = Application::findOrFail($applicationId);

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('application_id', $applicationId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Удалено из избранного']);
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'application_id' => $applicationId,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Добавлено в избранное']);
        }
    }
}
