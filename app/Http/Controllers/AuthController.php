<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Форма логина
    public function showLogin()
    {
        return view('auth.login');
    }

    // Логин пользователя
    public function login(Request $request)
    {
        // Валидация на сервере
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'     => 'Email обязателен',
            'email.email'        => 'Укажите корректный email',
            'password.required'  => 'Пароль обязателен',
            'password.min'       => 'Пароль должен быть минимум 6 символов',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return redirect()->route('home')->with('success', 'Вы успешно вошли!');
        }

        return back()->withErrors([
            'email' => 'Неверные учётные данные.',
        ])->onlyInput('email');
    }

    // Форма регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Валидация на сервере с парольной политикой
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_confirmation' => 'required|same:password',
        ], [
            'name.required'                    => 'Имя обязательно',
            'email.required'                   => 'Email обязателен',
            'email.email'                      => 'Укажите корректный email',
            'email.unique'                     => 'Этот email уже зарегистрирован',
            'password.required'                => 'Пароль обязателен',
            'password.min'                     => 'Пароль должен быть минимум 8 символов',
            'password.regex'                   => 'Пароль должен содержать: строчные буквы, прописные буквы, цифры',
            'password_confirmation.required'   => 'Подтверждение пароля обязательно',
            'password_confirmation.same'       => 'Пароли не совпадают',
        ]);

        // Создание пользователя
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Вы успешно зарегистрировались!');
    }

    // Логаут
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Вы вышли из системы');
    }
}
