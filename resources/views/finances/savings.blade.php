@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Metas de Ahorro</h1>

            <!-- Resumen de ahorro -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm bg-gradient" style="background: linear-gradient(to right, #1e3c72, #2a5298); color: white;">
                        <div class="card-body">
                            <h5 class="card-title">Total Ahorrado</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="display-6 mb-0">€{{ number_format($totalSaved, 2) }}</h2>
                                <i class="bi bi-piggy-bank-fill display-4 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Progreso General</h5>
                            @php
                                $progressPercentage = $totalTarget > 0 ? min(100, ($totalSaved / $totalTarget) * 100) : 0;
                            @endphp
                            <div class="progress mb-3" style="height: 12px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercentage }}%"
                                    aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted">
                                <span>Ahorrado: €{{ number_format($totalSaved, 2) }}</span>
                                <span>Meta Total: €{{ number_format($totalTarget, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metas activas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Metas de Ahorro Activas</h5>
                    <a href="{{ route('finances.savings.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Meta
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($activeGoals) > 0)
                        <div class="row">
                            @foreach($activeGoals as $goal)
                                <div class="col-md-4">
                                    <div class="card mb-3 border-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h5 class="card-title">{{ $goal->name }}</h5>
                                                <span class="badge bg-primary">Activa</span>
                                            </div>
                                            <h2 class="text-primary mb-2">€{{ number_format($goal->target_amount, 2) }}</h2>

                                            @if($goal->description)
                                                <p class="text-muted small mb-2">{{ Str::limit($goal->description, 50) }}</p>
                                            @endif

                                            <div class="progress mb-2" style="height: 10px">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $goal->progress_percentage }}%"
                                                    aria-valuenow="{{ $goal->progress_percentage }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">€{{ number_format($goal->current_amount, 2) }} ahorrado</span>
                                                <span class="text-muted">€{{ number_format($goal->remaining_amount, 2) }} restante</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-2">
                                                <a href="{{ route('finances.savings.show', $goal) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i> Detalles
                                                </a>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="{{ route('finances.savings.edit', $goal) }}" class="dropdown-item">
                                                                <i class="bi bi-pencil me-2"></i> Editar
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('finances.savings.status', $goal) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="paused">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bi bi-pause-circle me-2"></i> Pausar
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('finances.savings.complete', $goal) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bi bi-check-circle me-2"></i> Completar
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('finances.savings.destroy', $goal) }}" method="POST" class="d-inline"
                                                                onsubmit="return confirm('¿Estás seguro de eliminar esta meta de ahorro?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i> Eliminar
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="display-1 text-muted mb-3">
                                <i class="bi bi-piggy-bank"></i>
                            </div>
                            <h4 class="text-muted">Aún no tienes metas de ahorro activas</h4>
                            <p class="text-muted">Crea tu primera meta para comenzar a ahorrar</p>
                            <a href="{{ route('finances.savings.create') }}" class="btn btn-primary mt-3">
                                <i class="bi bi-plus-circle me-1"></i> Crear meta de ahorro
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metas pausadas -->
            @if(count($pausedGoals) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Metas de Ahorro Pausadas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($pausedGoals as $goal)
                            <div class="col-md-4">
                                <div class="card mb-3 border-warning">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h5 class="card-title">{{ $goal->name }}</h5>
                                            <span class="badge bg-warning text-dark">Pausada</span>
                                        </div>
                                        <h2 class="text-primary mb-2">€{{ number_format($goal->target_amount, 2) }}</h2>

                                        <div class="progress mb-2" style="height: 10px">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: {{ $goal->progress_percentage }}%"
                                                aria-valuenow="{{ $goal->progress_percentage }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">€{{ number_format($goal->current_amount, 2) }} ahorrado</span>
                                            <span class="text-muted">€{{ number_format($goal->remaining_amount, 2) }} restante</span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('finances.savings.show', $goal) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> Detalles
                                            </a>
                                            <form action="{{ route('finances.savings.status', $goal) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-play-circle me-1"></i> Reanudar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Metas completadas -->
            @if(count($completedGoals) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Metas de Ahorro Completadas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($completedGoals as $goal)
                            <div class="col-md-4">
                                <div class="card mb-3 border-success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h5 class="card-title">{{ $goal->name }}</h5>
                                            <span class="badge bg-success">Completada</span>
                                        </div>
                                        <h2 class="text-primary mb-2">€{{ number_format($goal->target_amount, 2) }}</h2>

                                        <div class="progress mb-2" style="height: 10px">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">€{{ number_format($goal->current_amount, 2) }} ahorrado</span>
                                            <span class="text-success">¡Meta alcanzada!</span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('finances.savings.show', $goal) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection