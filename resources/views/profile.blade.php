@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">My Profile</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> This is a placeholder for the Profile page.
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Joined:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ Auth::user()->created_at->format('F d, Y') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <button class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 text-md-end">
                            <strong>Password:</strong>
                        </div>
                        <div class="col-md-9">
                            <a href="{{ route('password.request') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-lock me-1"></i> Change Password
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 text-md-end">
                            <strong>Two-factor Auth:</strong>
                        </div>
                        <div class="col-md-9">
                            <button class="btn btn-outline-success btn-sm">
                                <i class="bi bi-shield-lock me-1"></i> Enable 2FA
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection