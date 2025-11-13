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
                                    <h6 class="card-title">Current Balance</h6>
                                    <h2 class="mb-0">$4,304.85</h2>
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
                                    <h6 class="card-title">Monthly Income</h6>
                                    <h2 class="mb-0">$4,580.00</h2>
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
                                    <h6 class="card-title">Monthly Expenses</h6>
                                    <h2 class="mb-0">$2,275.15</h2>
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
                            <h5 class="mb-0">Recent Transactions</h5>
                            <a href="{{ route('finances.transactions') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Grocery Shopping</h6>
                                        <span class="text-danger">-$85.25</span>
                                    </div>
                                    <p class="mb-1 text-muted small">SuperMarket Inc.</p>
                                    <small class="text-muted">Today</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Salary Deposit</h6>
                                        <span class="text-success">+$2,450.00</span>
                                    </div>
                                    <p class="mb-1 text-muted small">Acme Corporation</p>
                                    <small class="text-muted">Yesterday</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Electric Bill</h6>
                                        <span class="text-danger">-$95.40</span>
                                    </div>
                                    <p class="mb-1 text-muted small">PowerCo Utilities</p>
                                    <small class="text-muted">2 days ago</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Monthly Budget</h5>
                            <a href="{{ route('finances.budget') }}" class="btn btn-sm btn-outline-primary">Details</a>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Savings Goals Progress</h5>
                            <a href="{{ route('finances.savings') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Vacation Fund</h5>
                                            <div class="mb-3">
                                                <span class="display-4 text-primary">60%</span>
                                            </div>
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="card-text">$1,500 of $2,500</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Emergency Fund</h5>
                                            <div class="mb-3">
                                                <span class="display-4 text-primary">35%</span>
                                            </div>
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="card-text">$3,500 of $10,000</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">New Laptop</h5>
                                            <div class="mb-3">
                                                <span class="display-4 text-success">100%</span>
                                            </div>
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="card-text">$1,200 of $1,200</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
