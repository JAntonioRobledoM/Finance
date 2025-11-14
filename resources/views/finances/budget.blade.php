@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Gestión de Presupuesto</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Dashboard
                </a>
            </div>

            <!-- Contenedor de notificaciones -->
            <div id="notification-container" style="position: fixed; top: 10px; right: 10px; z-index: 9999; max-width: 350px;"></div>

            @if (session('success') || session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        @if(session('success'))
                            showGlobalNotification('{{ session('success') }}', 'success');
                        @endif
                        @if(session('error'))
                            showGlobalNotification('{{ session('error') }}', 'danger');
                        @endif
                    });
                </script>
            @endif

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen de Presupuesto Mensual</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#budgetModal">
                                <i class="bi bi-gear-fill me-1"></i> Configurar Presupuesto
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Presupuesto Total</h5>
                                            <h2 class="text-primary mb-3">€{{ number_format($budgetTotal, 2) }}</h2>

                                            @php
                                                $percentSpent = min(100, ($totalExpenses / $budgetTotal) * 100);
                                                $progressColor = $percentSpent > 90 ? 'bg-danger' : ($percentSpent > 70 ? 'bg-warning' : 'bg-success');
                                            @endphp

                                            <div class="progress mb-2" style="height: 15px">
                                                <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                                     style="width: {{ $percentSpent }}%"
                                                     aria-valuenow="{{ $percentSpent }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">{{ round($percentSpent) }}%</div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <span class="text-muted">€{{ number_format($totalExpenses, 2) }} gastado</span>
                                                <span class="text-{{ $budgetRemaining >= 0 ? 'success' : 'danger' }}">
                                                    {{ $budgetRemaining >= 0 ? 'Restante: €' . number_format($budgetRemaining, 2) : 'Excedido: €' . number_format(abs($budgetRemaining), 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gastos sin categoría -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-secondary text-white">
                                            <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Gastos sin Categoría</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($uncategorizedExpenses > 0)
                                                @php
                                                    $uncategorizedPercentage = min(100, ($uncategorizedExpenses / $budgetTotal) * 100);
                                                @endphp
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h6>Total sin categoría:</h6>
                                                    <h6 class="text-danger">€{{ number_format($uncategorizedExpenses, 2) }}</h6>
                                                </div>
                                                <div class="progress mb-2" style="height: 10px">
                                                    <div class="progress-bar bg-secondary" role="progressbar"
                                                        style="width: {{ $uncategorizedPercentage }}%"
                                                        aria-valuenow="{{ $uncategorizedPercentage }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <p class="text-muted small mt-3">
                                                    Estos son gastos que no tienen categoría asignada. Para un mejor seguimiento,
                                                    categoriza tus transacciones en la sección Transacciones.
                                                </p>
                                            @else
                                                <div class="alert alert-success">
                                                    <i class="bi bi-check-circle me-2"></i> No tienes gastos sin categoría. ¡Excelente!
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Gastos por Categoría</h5>
                                        </div>
                                        <div class="card-body">
                                            @if(count($categoryExpenses) > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach($categoryExpenses as $expense)
                                                        @php
                                                            $categoryPercentage = min(100, ($expense->total / $budgetTotal) * 100);
                                                            $categoryBadgeColor = 'bg-info';
                                                            if ($categoryPercentage > 90) {
                                                                $categoryBadgeColor = 'bg-danger';
                                                            } elseif ($categoryPercentage > 70) {
                                                                $categoryBadgeColor = 'bg-warning';
                                                            } elseif ($categoryPercentage > 40) {
                                                                $categoryBadgeColor = 'bg-success';
                                                            }
                                                        @endphp
                                                        <li class="list-group-item">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div>
                                                                    <span class="badge {{ $categoryBadgeColor }} me-2">{{ round($categoryPercentage) }}%</span>
                                                                    {{ $expense->category }}
                                                                </div>
                                                                <span>€{{ number_format($expense->total, 2) }}</span>
                                                            </div>
                                                            <div class="progress" style="height: 8px">
                                                                <div class="progress-bar {{ $categoryBadgeColor }}" role="progressbar"
                                                                     style="width: {{ $categoryPercentage }}%"
                                                                     aria-valuenow="{{ $categoryPercentage }}"
                                                                     aria-valuemin="0"
                                                                     aria-valuemax="100"></div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i> No hay gastos categorizados aún.
                                                </div>
                                            @endif

                                            <div class="d-grid gap-2 mt-4">
                                                <a href="{{ route('finances.categories') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-tag me-1"></i> Gestionar Categorías
                                                </a>
                                                <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-cash-coin me-1"></i> Ver Todas las Transacciones
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para configurar presupuesto -->
<div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="budgetModalLabel">
                    <i class="bi bi-gear-fill me-2"></i>Configurar Límite de Presupuesto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('finances.budget.save') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="budgetAmount" class="form-label">Límite de Presupuesto Mensual</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control" id="budgetAmount" name="amount" step="0.01" min="1"
                                value="{{ $userBudget ? $userBudget->amount : $budgetTotal }}" required>
                        </div>
                        <p class="small text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i> Establece tu límite de presupuesto mensual. Podrás
                            exceder este límite, pero verás advertencias cuando te acerques o sobrepases el límite.
                        </p>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i> Si estableces un límite menor que tus
                            gastos actuales (€{{ number_format($totalExpenses, 2) }}), se mostrará como excedido.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar Presupuesto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection