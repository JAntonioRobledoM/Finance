@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Dashboard</h1>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
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
                                        <p class="mb-1 text-muted small">{{ $transaction->category }}</p>
                                        <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
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
                            <h5 class="mb-0">Monthly Budget</h5>
                            <a href="{{ route('finances.budget') }}" class="btn btn-sm btn-outline-primary">Detalles</a>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-3 text-muted">Overall Budget: $3,500.00</h6>
                            <div class="progress mb-4" style="height: 20px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Housing</span>
                                    <span>$850.00 / $1,000.00</span>
                                </div>
                                <div class="progress" style="height: 10px">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Food & Dining</span>
                                    <span>$450.00 / $600.00</span>
                                </div>
                                <div class="progress" style="height: 10px">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Transportation</span>
                                    <span>$250.00 / $300.00</span>
                                </div>
                                <div class="progress" style="height: 10px">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 83%" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
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
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="income_description" name="description" placeholder="Salary, Investment, etc." required>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="income_category" class="form-label">Categoría</label>
                                    <select class="form-select" id="income_category" name="category">
                                        <option value="Salary">Salario</option>
                                        <option value="Investment">Salidas</option>
                                        <option value="Gift">Regalo</option>
                                        <option value="Side Hustle">Side Hustle</option>
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
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="expense_description" name="description" placeholder="Groceries, Rent, etc." required>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expense_category" class="form-label">Categoría</label>
                                    <select class="form-select" id="expense_category" name="category">
                                        <option value="Housing">Housing</option>
                                        <option value="Food">Food</option>
                                        <option value="Transportation">Transportation</option>
                                        <option value="Utilities">Utilities</option>
                                        <option value="Entertainment">Entertainment</option>
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Shopping">Shopping</option>
                                        <option value="Personal">Personal</option>
                                        <option value="Other">Other</option>
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
    </div>
</div>
@endsection
