<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Система недвижимости')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">НедвиЖка</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>

                @auth
                    @if(!Auth::user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('applications.index') }}">Мои заявки</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('applications.create') }}">Создать заявку</a></li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @else
                    <!--ТОЛЬКО ДЛЯ АДМИНОВ! -->
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="btn btn-warning text-dark ms-2" href="{{ route('admin.applications.index') }}">
                                <i class="bi bi-clipboard-check"></i> Просмотреть заявки
                            </a>
                        </li>
                    @endif

                    <!-- ВЫПАДАЮЩЕЕ МЕНЮ ПОЛЬЗОВАТЕЛЯ -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(!Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('applications.index') }}">
                                        <i class="bi bi-file-text"></i> Мои заявки
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Выйти из системы?')">
                                        <i class="bi bi-box-arrow-right"></i> Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container-fluid py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
