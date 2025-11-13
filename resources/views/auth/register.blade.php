@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg">
                <div class="row g-0">
                    <div class="col-md-5 bg-primary text-white d-flex flex-column justify-content-center align-items-center p-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Join Us Today</h2>
                            <p class="fs-5">Start managing your finances smarter</p>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="text-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </div>
                            <div class="my-4">
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    <span>Track all your expenses</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    <span>Set and manage budgets</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    <span>Get personalized insights</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    <span>Secure and private</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="card-title text-center mb-4 fw-bold">Create Account</h3>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                                        <label for="name">{{ __('Full Name') }}</label>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                                        <label for="email">{{ __('Email Address') }}</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-text small text-muted">We'll never share your email with anyone else.</div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                        <label for="password">{{ __('Password') }}</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-text small text-muted">Your password must be at least 8 characters long.</div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    </div>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label small" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary py-3 fw-semibold">
                                        {{ __('Create Account') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">Already have an account?
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Sign In</a>
                                    </p>
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
