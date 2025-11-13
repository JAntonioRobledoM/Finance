<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Personal Finance') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,500,600,700|Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 600;
        }
        .banking-nav {
            background-color: #1e3c72;
            background-image: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .banking-nav .navbar-brand,
        .banking-nav .nav-link {
            color: #ffffff;
        }
        .banking-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.85);
        }
        .btn-primary {
            background-color: #1e3c72;
            border-color: #1e3c72;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #152c54;
            border-color: #152c54;
        }
        .footer {
            background-color: #f1f3f5;
            padding: 1.5rem 0;
            margin-top: 3rem;
            color: #6c757d;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    @stack('scripts')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark banking-nav shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-bank me-2"></i>{{ config('app.name', 'Personal Finance') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-house-fill me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finances.transactions') ? 'active' : '' }}" href="{{ route('finances.transactions') }}"><i class="bi bi-cash-coin me-1"></i> Transacciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finances.categories') ? 'active' : '' }}" href="{{ route('finances.categories') }}"><i class="bi bi-tag me-1"></i> Categorías</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finances.analytics') ? 'active' : '' }}" href="{{ route('finances.analytics') }}"><i class="bi bi-bar-chart-line me-1"></i> Estadísticas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finances.budget') ? 'active' : '' }}" href="{{ route('finances.budget') }}"><i class="bi bi-calculator me-1"></i> Presupuesto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finances.savings') ? 'active' : '' }}" href="{{ route('finances.savings') }}"><i class="bi bi-piggy-bank-fill me-1"></i> Ahorros</a>
                        </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-outline-light me-2" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-light" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Registrarse</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="bi bi-person me-2"></i>Mi Perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('finances.categories') }}">
                                        <i class="bi bi-tag me-2"></i>Gestionar Categorías
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="bi bi-gear me-2"></i>Configuración
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="bi bi-bank me-2"></i>Gestor de Finanzas Personal</h5>
                        <p class="small">Tu solución segura para gestionar tus finanzas personales.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="small">&copy; {{ date('Y') }} Finanzas Personales. Todos los derechos reservados.</p>
                        <p class="small">Seguro y privado. Tus datos se guardan en tu dispositivo.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
