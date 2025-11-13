@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Financial Analytics</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Spending Insights</h5>
                    <div>
                        <select class="form-select form-select-sm">
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> This is a placeholder for the Analytics page.
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Income</h5>
                                    <h2 class="text-success">$4,580.00</h2>
                                    <p class="text-muted mb-0"><i class="bi bi-arrow-up-circle"></i> 12% from last period</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Expenses</h5>
                                    <h2 class="text-danger">$2,275.15</h2>
                                    <p class="text-muted mb-0"><i class="bi bi-arrow-down-circle"></i> 5% from last period</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Net Savings</h5>
                                    <h2 class="text-primary">$2,304.85</h2>
                                    <p class="text-muted mb-0"><i class="bi bi-arrow-up-circle"></i> 18% from last period</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Monthly Trend</h5>
                                    <div style="height: 200px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; border-radius: 5px;">
                                        <p class="text-muted mb-0">Chart placeholder - Income vs. Expenses</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Expense Breakdown</h5>
                                    <div style="height: 200px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; border-radius: 5px;">
                                        <p class="text-muted mb-0">Pie chart placeholder</p>
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