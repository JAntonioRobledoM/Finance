@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Budget Management</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Monthly Budget Overview</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Create Budget
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> This is a placeholder for the Budget page.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Budget</h5>
                                    <h2 class="text-primary mb-3">$3,500.00</h2>
                                    <div class="progress mb-2" style="height: 10px">
                                        <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">$2,275.15 spent</span>
                                        <span class="text-muted">$1,224.85 remaining</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Spending by Category</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-success me-2">Food</span>
                                                Housing
                                            </div>
                                            <span>$850.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-info me-2">Transportation</span>
                                                Transportation
                                            </div>
                                            <span>$250.00</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-warning text-dark me-2">Utilities</span>
                                                Utilities
                                            </div>
                                            <span>$175.15</span>
                                        </li>
                                    </ul>
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