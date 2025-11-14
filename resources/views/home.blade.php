@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Dashboard</h1>
                <div>
                    <a href="{{ route('finances.categories') }}" class="btn btn-primary me-2">
                        <i class="bi bi-tag me-1"></i> Gestionar Categorías
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </button>
                    </form>
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

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Dinero total</h6>
                                    <h2 class="mb-0">€{{ number_format($balance, 2) }}</h2>
                                </div>
                                <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Ingresos</h6>
                                    <h2 class="mb-0">€{{ number_format($totalIncome, 2) }}</h2>
                                </div>
                                <i class="bi bi-graph-up-arrow fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Gastos</h6>
                                    <h2 class="mb-0">€{{ number_format($totalExpense, 2) }}</h2>
                                </div>
                                <i class="bi bi-graph-down-arrow fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Transacciones recientes</h5>
                            <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-outline-primary">Todos</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse($recentTransactions as $transaction)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $transaction->description }}</h6>
                                            <span class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}€{{ number_format($transaction->amount, 2) }}
                                            </span>
                                        </div>
                                        <p class="mb-1 text-muted small">{{ $transaction->category ?? '-' }}</p>
                                        <small class="text-muted">{{ $transaction->effective_date->format('d/m/Y') }}</small>
                                    </div>
                                @empty
                                    <div class="list-group-item text-center py-4">
                                        <p class="mb-0 text-muted">Aún no hay transacciones</p>
                                        <small class="text-muted">Usa los formularios de abajo para añadir transacciones</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gastos por Categoría</h5>
                            <a href="{{ route('finances.budget') }}" class="btn btn-sm btn-outline-primary">Detalles</a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3 text-muted">Presupuesto Total: €{{ number_format($budgetTotal, 2) }}</h6>

                            @php
                                $totalExpenseAmount = $totalExpense;
                                $progressPercentage = min(100, ($totalExpenseAmount / $budgetTotal) * 100);
                                $progressColor = $progressPercentage > 90 ? 'bg-danger' : ($progressPercentage > 70 ? 'bg-warning' : 'bg-primary');
                            @endphp

                            <div class="progress mb-4" style="height: 20px">
                                <div class="progress-bar {{ $progressColor }}" role="progressbar"
                                     style="width: {{ $progressPercentage }}%"
                                     aria-valuenow="{{ $progressPercentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">{{ round($progressPercentage) }}%</div>
                            </div>

                            <h6 class="mb-3">Gastos por Categoría</h6>

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
                                        <div class="progress" style="height: 10px">
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
                                    No hay gastos categorizados aún.
                                </div>
                            @endif

                            <!-- Gastos sin categoría -->
                            <h6 class="mt-4 mb-3">Gastos sin Categoría</h6>

                            @php
                                $uncategorizedPercentage = min(100, ($uncategorizedExpenses / $budgetTotal) * 100);
                            @endphp

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Sin categoría</span>
                                    <span>€{{ number_format($uncategorizedExpenses, 2) }}</span>
                                </div>
                                <div class="progress" style="height: 10px">
                                    <div class="progress-bar bg-secondary"
                                         role="progressbar"
                                         style="width: {{ $uncategorizedPercentage }}%"
                                         aria-valuenow="{{ $uncategorizedPercentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <small class="text-muted">Añade categorías a tus gastos para un mejor seguimiento</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Añadir Ingreso</h5>
                        </div>
                        <div class="card-body">
                            <!-- Success messages are now shown as toast notifications -->

                            <form action="{{ route('finances.income.store') }}" method="POST">
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
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="income_description" name="description" placeholder="Salary, Investment, etc." required>
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

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-plus-circle me-2"></i> Añadir Ingreso
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="bi bi-dash-circle me-2"></i> Añadir Gasto</h5>
                        </div>
                        <div class="card-body">
                            <!-- Success messages are now shown as toast notifications -->

                            <form action="{{ route('finances.expense.store') }}" method="POST">
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
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="expense_description" name="description" placeholder="Groceries, Rent, etc." required>
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

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-dash-circle me-2"></i> Añadir Gasto
                                    </button>
                                </div>
                            </form>
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
