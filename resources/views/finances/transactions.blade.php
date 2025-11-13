@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Historial de Transacciones</h1>

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

            <!-- Mensajes de éxito y error -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
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
                                        <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            @if($transaction->type == 'income')
                                                <span class="badge bg-success">{{ $transaction->category }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $transaction->category }}</span>
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
                                            <form action="{{ route('finances.transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta transacción?')">
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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('finances.income.store') }}" method="POST">
                        @csrf
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
                            <label for="income_category" class="form-label">Categoría</label>
                            <select class="form-select" id="income_category" name="category">
                                <option value="Salary">Salario</option>
                                <option value="Investment">Inversión</option>
                                <option value="Gift">Regalo</option>
                                <option value="Side Hustle">Ingreso Extra</option>
                                <option value="Other">Otros</option>
                            </select>
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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('finances.expense.store') }}" method="POST">
                        @csrf
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
                            <label for="expense_category" class="form-label">Categoría</label>
                            <select class="form-select" id="expense_category" name="category">
                                <option value="Housing">Vivienda</option>
                                <option value="Food">Alimentación</option>
                                <option value="Transportation">Transporte</option>
                                <option value="Utilities">Servicios</option>
                                <option value="Entertainment">Entretenimiento</option>
                                <option value="Healthcare">Salud</option>
                                <option value="Shopping">Compras</option>
                                <option value="Personal">Personal</option>
                                <option value="Other">Otros</option>
                            </select>
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