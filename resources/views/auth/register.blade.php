@extends('layouts.app')
@section('title', 'Регистрация')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Регистрация</h2>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Ошибки:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                    @csrf

                    <!-- Имя -->
                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Пароль с требованиями -->
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        <!-- Требования к паролю -->
                        <small class="form-text text-muted mt-2">
                            <div id="password-requirements">
                                <p>Пароль должен содержать:</p>
                                <ul>
                                    <li><span id="length-check">❌</span> Минимум 8 символов</li>
                                    <li><span id="lowercase-check">❌</span> Строчные буквы (a-z)</li>
                                    <li><span id="uppercase-check">❌</span> Прописные буквы (A-Z)</li>
                                    <li><span id="number-check">❌</span> Цифры (0-9)</li>
                                </ul>
                            </div>
                        </small>
                    </div>

                    <!-- Подтверждение пароля -->
                    <div class="mb-3">
                        <label class="form-label">Подтверждение пароля</label>
                        <input type="password" name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               required>
                        @error('password_confirmation')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                    <p class="mt-3 text-center">Уже зарегистрированы? <a href="{{ route('login') }}">Войдите</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Реал-тайм проверка пароля
        const passwordInput = document.getElementById('password');
        const lengthCheck = document.getElementById('length-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const numberCheck = document.getElementById('number-check');

        passwordInput.addEventListener('input', function() {
            const pwd = this.value;

            // Проверка длины
            if (pwd.length >= 8) {
                lengthCheck.textContent = '✅';
            } else {
                lengthCheck.textContent = '❌';
            }

            // Проверка строчных букв
            if (/[a-z]/.test(pwd)) {
                lowercaseCheck.textContent = '✅';
            } else {
                lowercaseCheck.textContent = '❌';
            }

            // Проверка прописных букв
            if (/[A-Z]/.test(pwd)) {
                uppercaseCheck.textContent = '✅';
            } else {
                uppercaseCheck.textContent = '❌';
            }

            // Проверка цифр
            if (/[0-9]/.test(pwd)) {
                numberCheck.textContent = '✅';
            } else {
                numberCheck.textContent = '❌';
            }
        });
    </script>
@endsection
