@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center py-5">
                <h1 class="display-3 mb-4 fw-bold">Personal Finance Manager</h1>
                <p class="lead mb-4">Your secure solution for managing personal finances</p>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg overflow-hidden">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <div class="p-5" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                        <div class="text-white mb-5">
                                            <h2 class="fw-bold">Take Control of Your Finances</h2>
                                            <p class="opacity-75 mt-3">Start your journey to financial freedom today.</p>
                                        </div>
                                        <div class="d-flex flex-column gap-3 text-white">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Track Expenses</h5>
                                                    <p class="small opacity-75 mb-0">Monitor where your money goes</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Manage Budgets</h5>
                                                    <p class="small opacity-75 mb-0">Set limits and reach your goals</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Track Savings</h5>
                                                    <p class="small opacity-75 mb-0">Watch your wealth grow over time</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                                <div>
                                                    <h5 class="mb-0">Financial Insights</h5>
                                                    <p class="small opacity-75 mb-0">Analyze your spending patterns</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-white">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-4">Join Today</h3>
                                        <p class="text-muted mb-4">Create your account to get started with managing your personal finances more effectively.</p>

                                        @if (Route::has('login'))
                                            <div class="d-grid gap-2 mb-3">
                                                @auth
                                                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg py-3">
                                                        <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                                                    </a>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg py-3">
                                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login to Your Account
                                                    </a>

                                                    @if (Route::has('register'))
                                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg py-3">
                                                            <i class="bi bi-person-plus me-2"></i>Create New Account
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endif

                                        <div class="text-center mt-4">
                                            <p class="small text-muted">Secure and private. Your data stays on your device.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center mb-5">
                <div class="col-md-12">
                    <h2 class="fw-bold mb-4">Why Choose Our Platform?</h2>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Secure & Private</h4>
                            <p class="text-muted">Your financial data is encrypted and never shared with third parties.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-graph-up-arrow text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Powerful Analytics</h4>
                            <p class="text-muted">Gain insights into your spending habits with detailed financial reports.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-piggy-bank text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4>Goal Tracking</h4>
                            <p class="text-muted">Set savings goals and track your progress toward financial milestones.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4">Ready to Take Control of Your Finances?</h2>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="bi bi-arrow-right-circle me-2"></i>Get Started Now
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="bi bi-speedometer2 me-2"></i>Go to Your Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection