@extends('layouts.app')

@section('title', 'Мой профиль')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Мой профиль</h2>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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

                <!-- Вкладки -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="avatar-tab" data-bs-toggle="tab" data-bs-target="#avatar-content" type="button" role="tab">
                            <i class="bi bi-image"></i> Аватар
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="name-tab" data-bs-toggle="tab" data-bs-target="#name-content" type="button" role="tab">
                            <i class="bi bi-person"></i> Личные данные
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-content" type="button" role="tab">
                            <i class="bi bi-lock"></i> Пароль
                        </button>
                    </li>
                </ul>

                <div class="tab-content mt-4">
                    <!-- Вкладка: Аватар -->
                    <div class="tab-pane fade show active" id="avatar-content" role="tabpanel">
                        <div class="text-center">
                            @if(Auth::user()->avatar_path)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}?v={{ time() }}"
                                         alt="Аватар" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #0d6efd;">
                                </div>
                            @else
                                <div class="mb-4">
                                    <div class="rounded-circle" style="width: 200px; height: 200px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="bi bi-person-fill" style="font-size: 80px; color: #adb5bd;"></i>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('profile.uploadAvatar') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Загрузить аватар (JPG, PNG, GIF, макс 2МБ)</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                           name="avatar" id="avatar" accept="image/*" required>
                                    @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cloud-upload"></i> Загрузить аватар
                                </button>

                                @if(Auth::user()->avatar_path)
                                    <form method="POST" action="{{ route('profile.deleteAvatar') }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить аватар?')">
                                            <i class="bi bi-trash"></i> Удалить аватар
                                        </button>
                                    </form>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Вкладка: Личные данные -->
                    <div class="tab-pane fade" id="name-content" role="tabpanel">
                        <form method="POST" action="{{ route('profile.updateName') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Имя <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Отчество</label>
                                <input type="text" name="second_name" class="form-control @error('second_name') is-invalid @enderror"
                                       value="{{ old('second_name', Auth::user()->second_name) }}">
                                @error('second_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Фамилия</label>
                                <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror"
                                       value="{{ old('surname', Auth::user()->surname) }}">
                                @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                <small class="text-muted">Email не может быть изменён</small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Сохранить изменения
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Отмена</a>
                        </form>
                    </div>

                    <!-- Вкладка: Пароль -->
                    <div class="tab-pane fade" id="password-content" role="tabpanel">
                        <form method="POST" action="{{ route('profile.updatePassword') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Текущий пароль <span class="text-danger">*</span></label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       required>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Новый пароль <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="new_password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

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

                            <div class="mb-3">
                                <label class="form-label">Подтверждение пароля <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       required>
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Изменить пароль
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Отмена</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Реал-тайм проверка пароля
        const passwordInput = document.getElementById('new_password');
        const lengthCheck = document.getElementById('length-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const numberCheck = document.getElementById('number-check');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const pwd = this.value;

                if (pwd.length >= 8) {
                    lengthCheck.textContent = '✅';
                } else {
                    lengthCheck.textContent = '❌';
                }

                if (/[a-z]/.test(pwd)) {
                    lowercaseCheck.textContent = '✅';
                } else {
                    lowercaseCheck.textContent = '❌';
                }

                if (/[A-Z]/.test(pwd)) {
                    uppercaseCheck.textContent = '✅';
                } else {
                    uppercaseCheck.textContent = '❌';
                }

                if (/[0-9]/.test(pwd)) {
                    numberCheck.textContent = '✅';
                } else {
                    numberCheck.textContent = '❌';
                }
            });
        }
    </script>
@endsection
