@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Editar Transacción
                    </h5>
                    <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Volver
                    </a>
                </div>
                <div class="card-body">
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

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Estás editando la siguiente transacción:
                    </div>

                    <!-- Información de la transacción -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Fecha:</strong> {{ $transaction->effective_date->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Descripción:</strong> {{ $transaction->description }}</p>
                                    <p class="mb-1">
                                        <strong>Tipo:</strong>
                                        @if($transaction->type == 'income')
                                            <span class="text-success">Ingreso</span>
                                        @else
                                            <span class="text-danger">Gasto</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong>Cantidad:</strong>
                                        <span class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }} fw-bold">
                                            {{ $transaction->type == 'income' ? '+' : '-' }}€{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Categoría actual:</strong>
                                        @if($transaction->category)
                                            <span class="badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $transaction->category }}
                                            </span>
                                        @else
                                            <span class="text-muted">Sin categoría</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario para editar la categoría -->
                    <form action="{{ route('finances.transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Fecha de Transacción</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ $transaction->effective_date->format('Y-m-d') }}">
                            <small class="form-text text-muted">La fecha en que se realizó esta transacción</small>
                            @error('transaction_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                       id="amount" name="amount" step="0.01" min="0.01"
                                       value="{{ $transaction->amount }}" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">La cantidad de la transacción</small>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoría</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">-- Sin categoría --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ $transaction->category == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                                <option value="new_category" class="text-primary fw-bold">+ Crear nueva categoría</option>
                            </select>
                            @error('category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para nueva categoría (inicialmente oculto) -->
                        <div class="mb-3 d-none" id="new_category_div">
                            <label for="new_category" class="form-label">Nueva Categoría</label>
                            <input type="text" class="form-control" id="new_category" name="new_category" placeholder="Nombre de la nueva categoría">
                            @error('new_category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('finances.transactions') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>
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
    // Función para manejar la visibilidad del campo de nueva categoría
    document.getElementById('category').addEventListener('change', function() {
        const newCategoryDiv = document.getElementById('new_category_div');
        if (this.value === 'new_category') {
            newCategoryDiv.classList.remove('d-none');
            document.getElementById('new_category').setAttribute('required', true);
        } else {
            newCategoryDiv.classList.add('d-none');
            document.getElementById('new_category').removeAttribute('required');
        }
    });

    // Ejecutar al cargar para manejar el estado inicial
    window.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('category').value === 'new_category') {
            document.getElementById('new_category_div').classList.remove('d-none');
            document.getElementById('new_category').setAttribute('required', true);
        }
    });
</script>
@endpush