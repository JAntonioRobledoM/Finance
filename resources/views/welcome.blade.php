@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-pc-display-horizontal text-primary" style="font-size: 4rem;"></i>
                </div>
                <h1 class="display-4 mb-3 fw-bold">Finance Desktop</h1>
                <p class="lead mb-2">Aplicación de finanzas personales para tu escritorio</p>
                <div class="d-inline-flex align-items-center bg-success text-white px-3 py-2 rounded mb-4">
                    <i class="bi bi-hdd-fill me-2"></i>
                    <span class="fw-semibold">100% Local - Tus datos nunca salen de tu dispositivo</span>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <div class="p-5 h-100 d-flex flex-column" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                        <div class="text-white mb-4">
                                            <h2 class="fw-bold">Controla y maneja tu dinero</h2>
                                            <p class="opacity-75 mt-3">Comienza a usarla de forma totalmente gratuita y libre hoy</p>
                                        </div>
                                        <div class="d-flex flex-column gap-3 text-white grow">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Almacenamiento 100% Local</h5>
                                                    <p class="small opacity-75 mb-0">Tus datos nunca salen de tu dispositivo</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Maneja tus finanzas</h5>
                                                    <p class="small opacity-75 mb-0">Controla gastos e ingresos en tu escritorio</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Máxima privacidad</h5>
                                                    <p class="small opacity-75 mb-0">Sin conexiones externas ni envío de datos</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Siempre disponible</h5>
                                                    <p class="small opacity-75 mb-0">Funciona sin internet en tu ordenador</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-white">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-3">Aplicación de Escritorio</h3>
                                        <p class="text-muted mb-2">Crea tu cuenta local en tu dispositivo</p>
                                        <div class="alert alert-info mb-4">
                                            <div class="d-flex">
                                                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                                <div>
                                                    <strong>Modo local:</strong> Esta aplicación funciona completamente en tu dispositivo. Tus datos financieros nunca se envían a ningún servidor externo.
                                                </div>
                                            </div>
                                        </div>

                                        @if (Route::has('login'))
                                            <div class="d-grid gap-2 mb-3">
                                                @auth
                                                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg py-3">
                                                        <i class="bi bi-speedometer2 me-2"></i>Ir al Dashboard
                                                    </a>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg py-3">
                                                        <i class="bi bi-box-arrow-in-right me-2"></i>Inicia sesión
                                                    </a>

                                                    @if (Route::has('register'))
                                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg py-3">
                                                            <i class="bi bi-person-plus me-2"></i>Crea una nueva cuenta
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endif

                                        <div class="text-center mt-4">
                                            <div class="d-inline-flex align-items-center bg-light border px-3 py-2 rounded">
                                                <i class="bi bi-shield-lock-fill me-2 text-success"></i>
                                                <span class="small fw-semibold">Aplicación de escritorio: Tus datos nunca salen de tu dispositivo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center mb-5">
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <i class="bi bi-pc-display-horizontal text-primary me-2"></i>
                        <h2 class="fw-bold mb-0">Ventajas de la Aplicación de Escritorio</h2>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-hdd-fill text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4>Almacenamiento Local</h4>
                            <p class="text-muted">Tus datos financieros nunca salen de tu ordenador</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-shield-lock-fill text-success" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4>Máxima Privacidad</h4>
                            <p class="text-muted">Sin conexiones a Internet ni transferencia de datos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-lightning-fill text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4>Rápido y Eficiente</h4>
                            <p class="text-muted">Opera directamente en tu dispositivo sin depender de servidores externos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-pencil-square text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4>Control Total</h4>
                            <p class="text-muted">Tú controlas completamente tus datos financieros</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection