@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Gestión de Categorías</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i>Volver al Dashboard
                </a>
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

            <div class="row mb-4">
                <!-- Formulario para crear nueva categoría -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-tag me-2"></i> Crear Nueva Categoría</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('finances.categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre de la Categoría</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tipo de Categoría</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="income" value="income" checked>
                                        <label class="form-check-label text-success" for="income">
                                            <i class="bi bi-graph-up-arrow me-1"></i>Ingreso
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="expense" value="expense">
                                        <label class="form-check-label text-danger" for="expense">
                                            <i class="bi bi-graph-down-arrow me-1"></i>Gasto
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Crear Categoría
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Lista de categorías de ingresos -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-tag me-2"></i> Categorías de Ingresos</h5>
                        </div>
                        <div class="card-body">
                            @if($incomeCategories->count() > 0)
                                <div class="list-group">
                                    @foreach($incomeCategories as $category)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $category->name }}</span>
                                            <form action="{{ route('finances.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>Aún no hay categorías de ingresos creadas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Lista de categorías de gastos -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="bi bi-tag me-2"></i> Categorías de Gastos</h5>
                        </div>
                        <div class="card-body">
                            @if($expenseCategories->count() > 0)
                                <div class="list-group">
                                    @foreach($expenseCategories as $category)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $category->name }}</span>
                                            <form action="{{ route('finances.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>Aún no hay categorías de gastos creadas
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection