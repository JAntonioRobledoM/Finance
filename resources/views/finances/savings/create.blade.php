@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('finances.savings') }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
                <h1 class="mb-0">Nueva Meta de Ahorro</h1>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Información de la Meta</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('finances.savings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de la Meta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Describe para qué estás ahorrando (opcional).</div>
                        </div>

                        <div class="mb-3">
                            <label for="target_amount" class="form-label">Cantidad Objetivo <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                    id="target_amount" name="target_amount" value="{{ old('target_amount') }}"
                                    step="0.01" min="0.01" required>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">¿Cuánto dinero necesitas ahorrar para lograr esta meta?</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="target_date" class="form-label">Fecha Objetivo</label>
                                <input type="date" class="form-control @error('target_date') is-invalid @enderror"
                                    id="target_date" name="target_date" value="{{ old('target_date') }}">
                                @error('target_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">¿Para cuándo deseas lograr esta meta? (opcional)</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="form-label">Prioridad</label>
                            <select class="form-select @error('priority') is-invalid @enderror"
                                id="priority" name="priority">
                                <option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>Baja</option>
                                <option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>Media-Baja</option>
                                <option value="3" {{ old('priority') == 3 || old('priority') === null ? 'selected' : '' }}>Media</option>
                                <option value="4" {{ old('priority') == 4 ? 'selected' : '' }}>Media-Alta</option>
                                <option value="5" {{ old('priority') == 5 ? 'selected' : '' }}>Alta</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Establece la importancia de esta meta en relación a otras.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Crear Meta de Ahorro
                            </button>
                            <a href="{{ route('finances.savings') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection