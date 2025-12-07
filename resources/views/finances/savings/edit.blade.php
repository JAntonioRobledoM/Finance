@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('finances.savings.show', $goal) }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
                <h1 class="mb-0">Editar Meta de Ahorro</h1>
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

                    <form action="{{ route('finances.savings.update', $goal) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de la Meta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $goal->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3">{{ old('description', $goal->description) }}</textarea>
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
                                    id="target_amount" name="target_amount" value="{{ old('target_amount', $goal->target_amount) }}"
                                    step="0.01" min="{{ $goal->current_amount }}" required>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">La cantidad objetivo no puede ser menor que la cantidad actual ahorrada (€{{ number_format($goal->current_amount, 2) }}).</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date', $goal->start_date->format('Y-m-d')) }}" readonly>
                                <div class="form-text">La fecha de inicio no se puede cambiar.</div>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="target_date" class="form-label">Fecha Objetivo</label>
                                <input type="date" class="form-control @error('target_date') is-invalid @enderror"
                                    id="target_date" name="target_date" value="{{ old('target_date', $goal->target_date ? $goal->target_date->format('Y-m-d') : '') }}">
                                @error('target_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">¿Para cuándo deseas lograr esta meta? (opcional)</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                                <option value="active" {{ old('status', $goal->status) == 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="paused" {{ old('status', $goal->status) == 'paused' ? 'selected' : '' }}>Pausada</option>
                                <option value="completed" {{ old('status', $goal->status) == 'completed' ? 'selected' : '' }}>Completada</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="form-label">Prioridad <span class="text-danger">*</span></label>
                            <select class="form-select @error('priority') is-invalid @enderror"
                                id="priority" name="priority" required>
                                <option value="1" {{ old('priority', $goal->priority) == 1 ? 'selected' : '' }}>Baja</option>
                                <option value="2" {{ old('priority', $goal->priority) == 2 ? 'selected' : '' }}>Media-Baja</option>
                                <option value="3" {{ old('priority', $goal->priority) == 3 ? 'selected' : '' }}>Media</option>
                                <option value="4" {{ old('priority', $goal->priority) == 4 ? 'selected' : '' }}>Media-Alta</option>
                                <option value="5" {{ old('priority', $goal->priority) == 5 ? 'selected' : '' }}>Alta</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Establece la importancia de esta meta en relación a otras.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('finances.savings.show', $goal) }}" class="btn btn-outline-secondary">
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