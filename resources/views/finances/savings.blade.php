@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Savings Goals</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Savings Goals</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add New Goal
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> This is a placeholder for the Savings page.
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-title">Vacation Fund</h5>
                                        <span class="badge bg-primary">Active</span>
                                    </div>
                                    <h2 class="text-primary mb-3">$2,500.00</h2>
                                    <div class="progress mb-2" style="height: 10px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">$1,500 saved</span>
                                        <span class="text-muted">$1,000 to go</span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary">Add Funds</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-title">Emergency Fund</h5>
                                        <span class="badge bg-primary">Active</span>
                                    </div>
                                    <h2 class="text-primary mb-3">$10,000.00</h2>
                                    <div class="progress mb-2" style="height: 10px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">$3,500 saved</span>
                                        <span class="text-muted">$6,500 to go</span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary">Add Funds</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-title">New Laptop</h5>
                                        <span class="badge bg-success">Completed!</span>
                                    </div>
                                    <h2 class="text-primary mb-3">$1,200.00</h2>
                                    <div class="progress mb-2" style="height: 10px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">$1,200 saved</span>
                                        <span class="text-muted">Goal reached!</span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button class="btn btn-sm btn-outline-success">Withdraw Funds</button>
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