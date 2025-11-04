<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Показать страницу профиля
     */
    public function show()
    {
        return view('profile.show');
    }

    /**
     * Обновить имя пользователя
     */
    public function updateName(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Имя успешно обновлено!');
    }

    /**
     * Загрузить аватар
     */
    public function uploadAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.required' => 'Выберите файл аватара',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Допускаются только jpeg, png, jpg, gif',
            'avatar.max' => 'Размер файла не должен превышать 2МБ',
        ]);

        $user = Auth::user();

        // Удалить старый аватар если существует
        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Загрузить новый аватар
        $path = $request->file('avatar')->store('avatars', 'public');

        // Обновить в БД
        $user->update(['avatar_path' => $path]);

        return back()->with('success', 'Аватар успешно загружен!');
    }

    /**
     * Удалить аватар
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->update(['avatar_path' => null]);

        return back()->with('success', 'Аватар удалён!');
    }

    /**
     * Изменить пароль
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Укажите текущий пароль',
            'password.required' => 'Укажите новый пароль',
            'password.min' => 'Пароль должен быть минимум 8 символов',
            'password.regex' => 'Пароль должен содержать: строчные, прописные буквы и цифры',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        // Проверка текущего пароля
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        // Проверка что новый пароль не совпадает с текущим
        if (Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Новый пароль не должен совпадать с текущим']);
        }

        // Обновить пароль
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Пароль успешно изменён!');
    }
}
