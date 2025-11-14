@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Editar Categoría de Transacción
                    </h5>
                    <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-arrow-left me-1"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Estás editando la categoría para la siguiente transacción:
                    </div>

                    <!-- Información de la transacción -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Fecha:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
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
                            <label for="category" class="form-label">Nueva Categoría</label>
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