@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <!-- Barra de título estilo aplicación de escritorio -->
            <div class="card bg-light border mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="bg-success text-white p-2 rounded">
                                    <i class="bi bi-hdd-fill"></i> Datos locales
                                </span>
                            </div>
                            <h1 class="mb-0">Panel de Control</h1>
                        </div>
                        <div>
                            <a href="{{ route('finances.categories') }}" class="btn btn-primary me-2">
                                <i class="bi bi-tag me-1"></i> Gestionar Categorías
                            </a>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-1"></i> Opciones
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <div class="dropdown-item-text text-muted small">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Almacenamiento local activado
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="bi bi-person-circle me-2"></i> Perfil de usuario
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar aplicación
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor de notificaciones -->
            <div id="notification-container" style="position: fixed; top: 10px; right: 10px; z-index: 9999; max-width: 350px;"></div>

            @if (session('status') || session('success') || session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        @if(session('status'))
                            showGlobalNotification('{{ session('status') }}', 'success');
                        @endif
                        @if(session('success'))
                            showGlobalNotification('{{ session('success') }}', 'success');
                        @endif
                        @if(session('error'))
                            showGlobalNotification('{{ session('error') }}', 'danger');
                        @endif
                    });
                </script>
            @endif

            <div class="row">
                <!-- Contenido principal -->
                <div class="col-md-12">
                    <!-- Tarjetas de resumen con estilo de escritorio -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm border h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-wallet2 text-primary mb-2" style="font-size: 2.5rem;"></i>
                                    <h5 class="card-title">Balance Total</h5>
                                    <h2 class="text-primary mb-0">€{{ number_format($balance, 2) }}</h2>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid">
                                        <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i> Ver detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm border h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-graph-up-arrow text-success mb-2" style="font-size: 2.5rem;"></i>
                                    <h5 class="card-title">Ingresos (este mes)</h5>
                                    <h2 class="text-success mb-0">€{{ number_format($totalIncome, 2) }}</h2>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                                            <i class="bi bi-plus-circle me-1"></i> Añadir ingreso
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm border h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-graph-down-arrow text-danger mb-2" style="font-size: 2.5rem;"></i>
                                    <h5 class="card-title">Gastos (este mes)</h5>
                                    <h2 class="text-danger mb-0">€{{ number_format($totalExpense, 2) }}</h2>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                            <i class="bi bi-dash-circle me-1"></i> Añadir gasto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- Paneles de información y transacciones con estilo de escritorio -->
            <div class="row">
                <!-- Transacciones recientes con diseño de aplicación de escritorio -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border h-100">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history text-primary me-2"></i>
                                <h5 class="mb-0">Transacciones recientes</h5>
                            </div>
                            <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-list me-1"></i> Ver todas
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($recentTransactions as $transaction)
                                    <div class="list-group-item d-flex align-items-start justify-content-between">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : 'bg-danger' }} p-2 rounded-circle">
                                                        <i class="bi {{ $transaction->type === 'income' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $transaction->description }}</h6>
                                                    <div class="d-flex align-items-center">
                                                        <small class="me-2">
                                                            <i class="bi bi-tag-fill me-1 small text-muted"></i>
                                                            {{ $transaction->category ?? 'Sin categoría' }}
                                                        </small>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar-date me-1"></i>
                                                            {{ $transaction->effective_date->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="fs-5 {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}€{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center py-4">
                                        <i class="bi bi-inbox text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-0 text-muted">Aún no hay transacciones</p>
                                        <small class="text-muted">Utiliza los botones "Añadir ingreso" o "Añadir gasto" para comenzar</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success text-white me-1">
                                    <i class="bi bi-hdd-fill me-1"></i>Almacenamiento local
                                </span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                                    <i class="bi bi-plus-circle me-1"></i> Ingreso
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                    <i class="bi bi-dash-circle me-1"></i> Gasto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gastos por categoría con diseño de aplicación de escritorio -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border h-100">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                                <h5 class="mb-0">Gastos por Categoría</h5>
                            </div>
                            <a href="{{ route('finances.budget') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-calculator me-1"></i> Presupuesto
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light border mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-muted">Presupuesto Total:</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">€{{ number_format($budgetTotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            @php
                                $totalExpenseAmount = $totalExpense;
                                $progressPercentage = min(100, ($totalExpenseAmount / $budgetTotal) * 100);
                                $progressColor = $progressPercentage > 90 ? 'bg-danger' : ($progressPercentage > 70 ? 'bg-warning' : 'bg-primary');
                            @endphp

                            <div class="progress mb-3" style="height: 20px">
                                <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                     style="width: {{ $progressPercentage }}%"
                                     aria-valuenow="{{ $progressPercentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">{{ round($progressPercentage) }}%</div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total gastado:</span>
                                <span class="fw-semibold">€{{ number_format($totalExpense, 2) }}</span>
                            </div>

                            <hr>

                            <h6 class="mb-3 d-flex align-items-center">
                                <i class="bi bi-tags me-2 text-primary"></i>
                                Desglose por Categoría
                            </h6>

                            @if(count($categoryExpenses) > 0)
                                @foreach($categoryExpenses as $expense)
                                    @php
                                        $categoryPercentage = min(100, ($expense->total / $budgetTotal) * 100);
                                        $categoryProgressColor = 'bg-info';
                                        if ($categoryPercentage > 90) {
                                            $categoryProgressColor = 'bg-danger';
                                        } elseif ($categoryPercentage > 70) {
                                            $categoryProgressColor = 'bg-warning';
                                        } elseif ($categoryPercentage > 50) {
                                            $categoryProgressColor = 'bg-success';
                                        }
                                    @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>{{ $expense->category }}</span>
                                            <span>€{{ number_format($expense->total, 2) }}</span>
                                        </div>
                                        <div class="progress" style="height: 8px">
                                            <div class="progress-bar {{ $categoryProgressColor }}"
                                                 role="progressbar"
                                                 style="width: {{ $categoryPercentage }}%"
                                                 aria-valuenow="{{ $categoryPercentage }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    No hay gastos categorizados aún.
                                </div>
                            @endif

                            <!-- Gastos sin categoría -->
                            @if($uncategorizedExpenses > 0)
                                <hr>
                                <h6 class="mb-3 d-flex align-items-center text-muted">
                                    <i class="bi bi-question-circle me-2"></i>
                                    Sin categorizar
                                </h6>

                                @php
                                    $uncategorizedPercentage = min(100, ($uncategorizedExpenses / $budgetTotal) * 100);
                                @endphp

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Sin categoría</span>
                                        <span>€{{ number_format($uncategorizedExpenses, 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px">
                                        <div class="progress-bar bg-secondary"
                                             role="progressbar"
                                             style="width: {{ $uncategorizedPercentage }}%"
                                             aria-valuenow="{{ $uncategorizedPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <a href="{{ route('finances.categories') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-tags me-1"></i> Gestionar categorías
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de almacenamiento local -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-success shadow-sm">
                        <div class="card-body py-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check text-success me-2 fs-4"></i>
                                    <div>
                                        <h6 class="mb-0">Aplicación de Escritorio con Almacenamiento Local</h6>
                                        <small class="text-muted">Todos los datos se almacenan exclusivamente en tu dispositivo.</small>
                                    </div>
                                </div>
                                <a href="{{ route('privacy') }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-shield-lock me-1"></i> Política de privacidad
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir ingreso -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addIncomeModalLabel">
                    <i class="bi bi-plus-circle me-2"></i> Añadir Nuevo Ingreso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('finances.income.store') }}" method="POST" id="incomeForm">
                    @csrf
                    <div class="mb-3">
                        <label for="income_transaction_date" class="form-label">Fecha</label>
                        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="income_transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}">
                        @error('transaction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="income_amount" class="form-label">Cantidad</label>
                        <div class="input-group">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="income_amount" name="amount" step="0.01" min="0.01" placeholder="0.00" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="income_description" class="form-label">Descripción</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="income_description" name="description" placeholder="Salario, Inversión, etc." required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="income_category" class="form-label">Categoría (opcional)</label>
                        <select class="form-select" id="income_category" name="category">
                            <option value="">-- Selecciona una categoría --</option>
                            @foreach($incomeCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="new_category" class="text-primary fw-bold">+ Crear nueva categoría</option>
                        </select>
                        <small class="form-text text-muted">Selecciona una categoría existente o crea una nueva</small>
                    </div>

                    <!-- Campo para nueva categoría (inicialmente oculto) -->
                    <div class="mb-3 d-none" id="new_income_category_div">
                        <label for="new_income_category" class="form-label">Nueva Categoría</label>
                        <input type="text" class="form-control" id="new_income_category" name="new_category" placeholder="Nombre de la nueva categoría">
                    </div>
                </form>
                <div class="alert alert-success">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <small>Todos los datos se almacenan localmente en tu dispositivo.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Cancelar
                </button>
                <button type="submit" form="incomeForm" class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i> Añadir Ingreso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir gasto -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="addExpenseModalLabel">
                    <i class="bi bi-dash-circle me-2"></i> Añadir Nuevo Gasto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('finances.expense.store') }}" method="POST" id="expenseForm">
                    @csrf
                    <div class="mb-3">
                        <label for="expense_transaction_date" class="form-label">Fecha</label>
                        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" id="expense_transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}">
                        @error('transaction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="expense_amount" class="form-label">Cantidad</label>
                        <div class="input-group">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="expense_amount" name="amount" step="0.01" min="0.01" placeholder="0.00" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="expense_description" class="form-label">Descripción</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="expense_description" name="description" placeholder="Comida, Alquiler, etc." required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="expense_category" class="form-label">Categoría (opcional)</label>
                        <select class="form-select" id="expense_category" name="category">
                            <option value="">-- Selecciona una categoría --</option>
                            @foreach($expenseCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="new_category" class="text-primary fw-bold">+ Crear nueva categoría</option>
                        </select>
                        <small class="form-text text-muted">Selecciona una categoría existente o crea una nueva</small>
                    </div>

                    <!-- Campo para nueva categoría (inicialmente oculto) -->
                    <div class="mb-3 d-none" id="new_expense_category_div">
                        <label for="new_expense_category" class="form-label">Nueva Categoría</label>
                        <input type="text" class="form-control" id="new_expense_category" name="new_category" placeholder="Nombre de la nueva categoría">
                    </div>
                </form>
                <div class="alert alert-success">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <small>Todos los datos se almacenan localmente en tu dispositivo.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Cancelar
                </button>
                <button type="submit" form="expenseForm" class="btn btn-danger">
                    <i class="bi bi-dash-circle me-2"></i> Añadir Gasto
                </button>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Función para manejar la visibilidad del campo de nueva categoría de ingresos
    document.getElementById('income_category').addEventListener('change', function() {
        const newCategoryDiv = document.getElementById('new_income_category_div');
        if (this.value === 'new_category') {
            newCategoryDiv.classList.remove('d-none');
            document.getElementById('new_income_category').setAttribute('required', true);
        } else {
            newCategoryDiv.classList.add('d-none');
            document.getElementById('new_income_category').removeAttribute('required');
        }
    });

    // Función para manejar la visibilidad del campo de nueva categoría de gastos
    document.getElementById('expense_category').addEventListener('change', function() {
        const newCategoryDiv = document.getElementById('new_expense_category_div');
        if (this.value === 'new_category') {
            newCategoryDiv.classList.remove('d-none');
            document.getElementById('new_expense_category').setAttribute('required', true);
        } else {
            newCategoryDiv.classList.add('d-none');
            document.getElementById('new_expense_category').removeAttribute('required');
        }
    });
</script>
@endpush
