@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('finances.savings') }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
                <h1 class="mb-0">{{ $goal->name }}</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Información de la meta -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detalles de la Meta</h5>
                            <div>
                                <span class="badge {{ $goal->status == 'active' ? 'bg-primary' : ($goal->status == 'completed' ? 'bg-success' : 'bg-warning text-dark') }}">
                                    {{ $goal->status == 'active' ? 'Activa' : ($goal->status == 'completed' ? 'Completada' : 'Pausada') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($goal->description)
                                <div class="mb-4">
                                    <h6 class="text-muted">Descripción:</h6>
                                    <p>{{ $goal->description }}</p>
                                </div>
                            @endif

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Cantidad Objetivo:</h6>
                                    <h3 class="text-primary">€{{ number_format($goal->target_amount, 2) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Cantidad Actual:</h6>
                                    <h3 class="{{ $goal->current_amount >= $goal->target_amount ? 'text-success' : 'text-primary' }}">
                                        €{{ number_format($goal->current_amount, 2) }}
                                    </h3>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted mb-2">Progreso:</label>
                                <div class="progress" style="height: 20px">
                                    <div class="progress-bar {{ $goal->status == 'completed' ? 'bg-success' : ($goal->status == 'active' ? 'bg-primary' : 'bg-warning') }}"
                                        role="progressbar"
                                        style="width: {{ $goal->progress_percentage }}%"
                                        aria-valuenow="{{ $goal->progress_percentage }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ number_format($goal->progress_percentage, 1) }}%
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-muted small">€{{ number_format($goal->current_amount, 2) }} ahorrado</span>
                                    <span class="text-muted small">
                                        @if($goal->current_amount >= $goal->target_amount)
                                            <span class="text-success">¡Meta alcanzada!</span>
                                        @else
                                            €{{ number_format($goal->remaining_amount, 2) }} restante
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Fecha de Inicio:</h6>
                                    <p>{{ $goal->start_date->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Fecha Objetivo:</h6>
                                    <p>{{ $goal->target_date ? $goal->target_date->format('d/m/Y') : 'No especificada' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Prioridad:</h6>
                                    <p>
                                        @if($goal->priority == 1)
                                            <span class="badge bg-secondary">Baja</span>
                                        @elseif($goal->priority == 2)
                                            <span class="badge bg-info">Media-Baja</span>
                                        @elseif($goal->priority == 3)
                                            <span class="badge bg-primary">Media</span>
                                        @elseif($goal->priority == 4)
                                            <span class="badge bg-warning text-dark">Media-Alta</span>
                                        @else
                                            <span class="badge bg-danger">Alta</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Fecha de Creación:</h6>
                                    <p>{{ $goal->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('finances.savings.edit', $goal) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>

                                @if($goal->status == 'active')
                                    <form action="{{ route('finances.savings.status', $goal) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="paused">
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="bi bi-pause-circle me-1"></i> Pausar
                                        </button>
                                    </form>
                                @endif

                                @if($goal->status == 'paused')
                                    <form action="{{ route('finances.savings.status', $goal) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="active">
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-play-circle me-1"></i> Reanudar
                                        </button>
                                    </form>
                                @endif

                                @if($goal->status != 'completed')
                                    <form action="{{ route('finances.savings.complete', $goal) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-check-circle me-1"></i> Marcar como Completada
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('finances.savings.destroy', $goal) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar esta meta de ahorro? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario para añadir contribución -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Añadir Contribución</h5>
                        </div>
                        <div class="card-body">
                            @if($goal->status != 'completed')
                                <form action="{{ route('finances.contributions.store', $goal) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                                id="amount" name="amount" value="{{ old('amount') }}"
                                                step="0.01" min="0.01" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Tipo <span class="text-danger">*</span></label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Depósito</option>
                                            <option value="withdrawal" {{ old('type') == 'withdrawal' ? 'selected' : '' }}>Retiro</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" value="{{ old('description') }}">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="contribution_date" class="form-label">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('contribution_date') is-invalid @enderror"
                                            id="contribution_date" name="contribution_date" value="{{ old('contribution_date', date('Y-m-d')) }}" required>
                                        @error('contribution_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i> Añadir
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-success mb-0">
                                    <i class="bi bi-check-circle me-2"></i> Esta meta ya está completada. No se pueden añadir más contribuciones.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de contribuciones -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Historial de Contribuciones</h5>
                </div>
                <div class="card-body">
                    @if(count($contributions) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contributions as $contribution)
                                        <tr>
                                            <td>{{ $contribution->contribution_date->format('d/m/Y') }}</td>
                                            <td>
                                                @if($contribution->type == 'deposit')
                                                    <span class="badge bg-success">Depósito</span>
                                                @else
                                                    <span class="badge bg-danger">Retiro</span>
                                                @endif
                                            </td>
                                            <td class="{{ $contribution->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                                {{ $contribution->type == 'deposit' ? '+' : '-' }}€{{ number_format($contribution->amount, 2) }}
                                            </td>
                                            <td>{{ $contribution->description ?? '-' }}</td>
                                            <td>
                                                <form action="{{ route('finances.contributions.destroy', $contribution) }}" method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta contribución? Esta acción no se puede deshacer.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="display-1 text-muted mb-3">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <h4 class="text-muted">No hay contribuciones aún</h4>
                            <p class="text-muted">Comienza a ahorrar para esta meta añadiendo tu primera contribución.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection