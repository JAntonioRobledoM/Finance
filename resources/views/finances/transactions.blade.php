@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Historial de Transacciones</h1>
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

            <!-- Tarjetas de resumen -->
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

            <!-- Tabla de transacciones -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Todas las Transacciones</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Añadir Transacciones
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Categoría</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->effective_date->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            @if($transaction->category)
                                                @if($transaction->type == 'income')
                                                    <span class="badge bg-success">{{ $transaction->category }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $transaction->category }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->type == 'income')
                                                <span class="text-success">Ingreso</span>
                                            @else
                                                <span class="text-danger">Gasto</span>
                                            @endif
                                        </td>
                                        <td class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type == 'income' ? '+' : '-' }}€{{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>
                                            <!-- Botón de editar transacción -->
                                            <a href="{{ route('finances.transactions.edit', $transaction->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar transacción">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Formulario para eliminar transacción -->
                                            <form action="{{ route('finances.transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar transacción">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="mb-0 text-muted">Aún no hay transacciones</p>
                                            <small class="text-muted">Usa los formularios en el dashboard para añadir transacciones</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formularios para añadir transacciones -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Añadir Ingreso</h5>
                </div>
                <div class="card-body">
                    <!-- Las notificaciones ahora se muestran arriba -->

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
                    <!-- Las notificaciones ahora se muestran arriba -->

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

    // Evitar las confirmaciones en los formularios de eliminación
    // Ya no usamos confirmaciones para mejorar la experiencia del usuario
    document.addEventListener('DOMContentLoaded', function() {
        // No es necesario interceptar los formularios, ya que queremos que se envíen directamente
        // Las notificaciones se mostrarán después de la acción a través del sistema de sesiones
    });
</script>
@endpush