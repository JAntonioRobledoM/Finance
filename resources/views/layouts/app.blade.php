<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Finance') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,500,600,700|Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .desktop-nav {
            background-color: #2b3a4a;
            border-bottom: 1px solid #1a2533;
        }

        .desktop-nav .navbar-brand,
        .desktop-nav .nav-link {
            color: #ffffff;
        }

        .desktop-nav .nav-link {
            padding: 0.8rem 1rem;
            border-radius: 4px;
            margin-right: 3px;
        }

        .desktop-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .desktop-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 0.8rem 1.25rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #3050a0;
            border-color: #3050a0;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #253c80;
            border-color: #253c80;
        }

        main {
            flex: 1;
            padding: 1.5rem 0;
            background-color: #f0f0f0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            margin-top: auto;
        }

        .status-bar {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.75rem;
            padding: 0.25rem 1rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .local-storage-badge {
            background-color: rgba(40, 167, 69, 0.8);
            color: white;
            padding: 0.15rem 0.4rem;
            border-radius: 3px;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 2px;
            border: 1px solid rgba(40, 167, 69, 1);
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f8f8f8;
        }

        ::-webkit-scrollbar-thumb {
            background: #d4d4d4;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #b0b0b0;
        }

        /* App header styles */
        .app-header {
            display: flex;
            align-items: center;
        }
    </style>

    <!-- Scripts -->
    <!-- Comentamos la directiva Vite que está causando problemas -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css']) -->

    <!-- Usamos enlaces directos a CDN de Bootstrap como alternativa -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Global notification helper function -->
    <script>
        function showGlobalNotification(message, type) {
            // Check if the container exists, or create it
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.style = 'position: fixed; top: 10px; right: 10px; z-index: 9999; max-width: 350px;';
                document.body.appendChild(container);
            }

            // Create the notification
            const notification = document.createElement('div');
            notification.className = `toast align-items-center text-white bg-${type} border-0 mb-2`;
            notification.role = 'alert';
            notification.setAttribute('aria-live', 'assertive');
            notification.setAttribute('aria-atomic', 'true');

            notification.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            container.appendChild(notification);

            // Check if Bootstrap is loaded
            if (typeof bootstrap !== 'undefined') {
                const toast = new bootstrap.Toast(notification, {
                    autohide: true,
                    delay: 3000
                });

                toast.show();

                // Auto-remove notification after it's hidden
                notification.addEventListener('hidden.bs.toast', function() {
                    container.removeChild(notification);
                });
            } else {
                // Fallback if Bootstrap is not available
                notification.style.display = 'block';
                notification.style.backgroundColor = type === 'success' ? '#198754' : type === 'danger' ? '#dc3545' : '#0d6efd';
                notification.style.color = '#fff';
                notification.style.padding = '10px';
                notification.style.marginBottom = '10px';
                notification.style.borderRadius = '4px';

                // Auto-hide after 3 seconds
                setTimeout(() => {
                    container.removeChild(notification);
                }, 3000);
            }
        }
    </script>

    @stack('scripts')
</head>
<body>
    <div id="app">
        <!-- Barra de título de la aplicación -->
        <div class="bg-dark text-white py-2 px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bi bi-bank me-2 fs-5"></i>
            </div>
            <div class="text-center flex-grow-1">
                <span class="fs-6 fw-semibold">{{ config('app.name', 'Finance') }} - Aplicación de Finanzas Personales</span>
            </div>
            <div>
                <small class="text-white-50">v1.0.0</small>
            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-dark desktop-nav shadow-sm py-1">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-bank me-2"></i>{{ config('app.name', 'Finance') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Alternar navegación') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar - Application Menu -->
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

                    <!-- Right Side Of Navbar - User Menu -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-outline-light btn-sm me-2" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-light btn-sm" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Registrarse</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <span class="nav-link local-storage-badge me-2" title="Tus datos se almacenan localmente en tu dispositivo">
                                    <i class="bi bi-hdd-fill"></i> Local
                                </span>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-header pb-0 text-muted">
                                        <small><i class="bi bi-database me-1"></i> Datos almacenados localmente</small>
                                    </div>
                                    <div class="dropdown-divider"></div>
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

        <!-- Notificación de almacenamiento local -->
        <div class="local-storage-notification bg-light border-bottom py-1 px-3 text-center">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div></div> <!-- Espaciador -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock text-success me-2"></i>
                        <span class="text-muted small">Almacenamiento 100% local - Tus datos nunca salen de tu dispositivo</span>
                    </div>
                    <button type="button" class="btn-close btn-sm" onclick="hideLocalStorageNotification()"></button>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- Script para la notificación -->
        <script>
            function hideLocalStorageNotification() {
                document.querySelector('.local-storage-notification').style.display = 'none';
                localStorage.setItem('localStorageNotificationHidden', 'true');
            }

            document.addEventListener('DOMContentLoaded', function() {
                if (localStorage.getItem('localStorageNotificationHidden') === 'true') {
                    document.querySelector('.local-storage-notification').style.display = 'none';
                }
            });
        </script>

        <!-- Barra de estado -->
        <div class="status-bar">
            <div>
                <i class="bi bi-shield-lock text-success me-1"></i>
                <small>Datos protegidos</small>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('terms') }}" class="text-muted small">Términos y Condiciones</a>
                <a href="{{ route('privacy') }}" class="text-muted small">Política de Privacidad</a>
                <span class="text-muted small">&copy; {{ date('Y') }} Finance</span>
            </div>
        </div>

        <!-- Footer compacto -->
        <footer class="footer d-md-none">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="small mb-1">
                            <i class="bi bi-shield-lock me-1 text-success"></i>
                            <span>Datos protegidos en tu dispositivo</span>
                        </p>
                        <p class="small">&copy; {{ date('Y') }} Finance. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
