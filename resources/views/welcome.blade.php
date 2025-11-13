@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center py-5">
                <h1 class="display-3 mb-4 fw-bold">APP Personal de Finanzas</h1>
                <p class="lead mb-4">Aplicación de uso local y personal donde controlar tu dinero</p>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <div class="p-5" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                        <div class="text-white mb-5">
                                            <h2 class="fw-bold">Controla y maneja tu dinero</h2>
                                            <p class="opacity-75 mt-3">Comienza a usarla de forma totalmente gratuita y libre hoy</p>
                                        </div>
                                        <div class="d-flex flex-column gap-3 text-white">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Controlar tus gastos</h5>
                                                    <p class="small opacity-75 mb-0">Monitorea a dónde va tu dinero</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Maneja tus ahorros</h5>
                                                    <p class="small opacity-75 mb-0">Pon objetivos de ahorro</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Apunta tus ingresos</h5>
                                                    <p class="small opacity-75 mb-0">Añade los ingresos que tengas para controlarlos</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Mira tu total</h5>
                                                    <p class="small opacity-75 mb-0">Controla el total de tu dinero</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-white">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-4">Únete</h3>
                                        <p class="text-muted mb-4">Crea tu cuenta y maneja tu dinero</p>

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
                                            <p class="small text-muted">Seguro y privado. Tus datos se guardan en tu dispositivo.</p>
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
                    <h2 class="fw-bold mb-4">¿Por qué elegir nuestra plataforma?</h2>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Seguro y Privado</h4>
                            <p class="text-muted">Tus datos solo se encuentran en tu dispositivo</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-graph-up-arrow text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Estadísticas reales</h4>
                            <p class="text-muted">Cálculo exacto de diferentes movimientos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-piggy-bank text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Objetivos</h4>
                            <p class="text-muted">Marca tus propios objetivos y lleva tu control personal</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4">¿Preparado para controlar tus financias?</h2>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="bi bi-arrow-right-circle me-2"></i>Comienza ahora
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="bi bi-speedometer2 me-2"></i>Ve a tu dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection