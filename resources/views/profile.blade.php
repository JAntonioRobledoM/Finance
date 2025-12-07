@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Mi Perfil</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Esta es una página de perfil temporal.
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Nombre:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Correo electrónico:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Registrado:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->created_at->format('F d, Y') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#editProfileForm" aria-expanded="false" aria-controls="editProfileForm">
                                <i class="bi bi-pencil me-1"></i> Editar Perfil
                            </button>
                        </div>
                    </div>

                    <div class="collapse mt-4" id="editProfileForm">
                        <div class="card card-body border-0 bg-light">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-3 col-form-label text-md-end">Nombre:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="email" class="col-md-3 col-form-label text-md-end">Correo electrónico:</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-save me-1"></i> Guardar Cambios
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="collapse" data-bs-target="#editProfileForm">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Configuración de Seguridad</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Contraseña:</strong>
                        </div>
                        <div class="col-md-9">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#changePasswordForm" aria-expanded="false" aria-controls="changePasswordForm">
                                <i class="bi bi-lock me-1"></i> Cambiar Contraseña
                            </button>
                        </div>
                    </div>

                    <div class="collapse mt-3" id="changePasswordForm">
                        <div class="card card-body border-0 bg-light">
                            <form action="{{ route('profile.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 row">
                                    <label for="current_password" class="col-md-4 col-form-label text-md-end">Contraseña actual:</label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Nueva contraseña:</label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirmar contraseña:</label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-lg me-1"></i> Actualizar Contraseña
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="collapse" data-bs-target="#changePasswordForm">
                                            Cancelar
                                        </button>
                                    </div>
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