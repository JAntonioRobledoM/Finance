@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Transactions</h1>
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Transactions</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Transaction
                    </button>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> This is a placeholder for the Transactions page.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ date('Y-m-d') }}</td>
                                    <td>Grocery Shopping</td>
                                    <td><span class="badge bg-success">Food</span></td>
                                    <td class="text-danger">-$85.25</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime('-1 day')) }}</td>
                                    <td>Salary Deposit</td>
                                    <td><span class="badge bg-primary">Income</span></td>
                                    <td class="text-success">+$2,450.00</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime('-2 days')) }}</td>
                                    <td>Electric Bill</td>
                                    <td><span class="badge bg-warning text-dark">Utilities</span></td>
                                    <td class="text-danger">-$95.40</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection