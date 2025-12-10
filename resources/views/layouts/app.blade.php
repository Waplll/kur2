<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Система недвижимости')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background-color: #C5D5E4;">
<nav class="navbar navbar-expand-lg" style="background-color: #1F5278;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Нексус" style="height: 36px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link text-white" href="/">Главная</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('reviews.index') }}">Отзывы</a></li>
                @auth
                    @if(!Auth::user()->isAdmin())
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('applications.index') }}">Мои заявки</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('applications.create') }}">Создать заявку</a></li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @else
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="btn btn-warning text-dark ms-2" href="{{ route('admin.applications.index') }}">
                                <i class="bi bi-clipboard-check"></i> Просмотреть заявки
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-gear"></i> Мой профиль
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
<!-- Footer -->
<footer class="footer mt-5" style="background-color: #1F5278; color: white; padding: 40px 0; margin-top: 60px;">
    <div class="container">
        <div class="row mb-5">
            <!-- Информация -->
            <div class="col-md-6">
                <div class="mb-4">
                    <h5 style="color: #C5D5E4; margin-bottom: 20px;">Контактная информация</h5>

                    <div class="mb-3">
                        <small style="color: #C5D5E4;">Адрес</small>
                        <div>Томск, ул. Ленина 59a</div>
                    </div>

                    <div class="mb-3">
                        <small style="color: #C5D5E4;">Режим работы</small>
                        <div>пн-суб 9:00-22:00</div>
                    </div>

                    <div class="mb-3">
                        <small style="color: #C5D5E4;">Горячая линия</small>
                        <div><a href="tel:+79234153320" style="color: white; text-decoration: none;">+7-923-415-33-20</a></div>
                    </div>
                </div>
            </div>

            <!-- Карта -->
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d463.21189370846764!2d84.9509877918995!3d56.47776075240252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sru!4v1764826014309!5m2!1sru!2sru"
                        width="100%"
                        height="250"
                        style="border:0; border-radius: 8px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Разделитель -->
        <hr style="border-color: rgba(255,255,255,0.2);">

        <!-- Нижняя часть -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div style="color: #C5D5E4;">
                    <strong>ООО "Нексус"</strong> — управление недвижимостью
                </div>
            </div>

            <div class="col-md-6 text-md-end">
                <div class="social-icons">
                    <a href="#" style="color: white; margin-right: 20px; text-decoration: none; font-size: 20px;">
                        <i class="bi bi-vimeo"></i> VK
                    </a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 20px;">
                        <i class="bi bi-telegram"></i> Telegram
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4" style="color: #C5D5E4; font-size: 12px;">
            <p>&copy; 2025 Нексус. Все права защищены.</p>
        </div>
    </div>
</footer>
</body>
</html>
