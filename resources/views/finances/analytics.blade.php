@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="mb-3">Estadísticas Financieras</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Análisis de Gastos e Ingresos</h5>
                    <div>
                        <form id="period-form" action="{{ route('finances.analytics') }}" method="GET">
                            <select class="form-select form-select-sm" name="period" id="period-selector" onchange="this.form.submit()">
                                <option value="30days" {{ $period == '30days' ? 'selected' : '' }}>Últimos 30 días</option>
                                <option value="90days" {{ $period == '90days' ? 'selected' : '' }}>Últimos 3 meses</option>
                                <option value="180days" {{ $period == '180days' ? 'selected' : '' }}>Últimos 6 meses</option>
                                <option value="365days" {{ $period == '365days' ? 'selected' : '' }}>Último año</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Año actual</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3 border-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Ingresos Totales</h5>
                                    <h2 class="text-success">€{{ number_format($summaryData['income']['current'], 2) }}</h2>
                                    <p class="text-muted mb-0">
                                        @if($summaryData['income']['change'] > 0)
                                            <i class="bi bi-arrow-up-circle text-success"></i>
                                            <span class="text-success">{{ number_format($summaryData['income']['change'], 1) }}%</span>
                                        @elseif($summaryData['income']['change'] < 0)
                                            <i class="bi bi-arrow-down-circle text-danger"></i>
                                            <span class="text-danger">{{ number_format(abs($summaryData['income']['change']), 1) }}%</span>
                                        @else
                                            <i class="bi bi-dash-circle"></i> 0%
                                        @endif
                                        respecto al período anterior
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 border-danger">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Gastos Totales</h5>
                                    <h2 class="text-danger">€{{ number_format($summaryData['expense']['current'], 2) }}</h2>
                                    <p class="text-muted mb-0">
                                        @if($summaryData['expense']['change'] > 0)
                                            <i class="bi bi-arrow-up-circle text-danger"></i>
                                            <span class="text-danger">{{ number_format($summaryData['expense']['change'], 1) }}%</span>
                                        @elseif($summaryData['expense']['change'] < 0)
                                            <i class="bi bi-arrow-down-circle text-success"></i>
                                            <span class="text-success">{{ number_format(abs($summaryData['expense']['change']), 1) }}%</span>
                                        @else
                                            <i class="bi bi-dash-circle"></i> 0%
                                        @endif
                                        respecto al período anterior
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Ahorro Neto</h5>
                                    <h2 class="{{ $summaryData['savings']['current'] >= 0 ? 'text-primary' : 'text-danger' }}">
                                        €{{ number_format($summaryData['savings']['current'], 2) }}
                                    </h2>
                                    <p class="text-muted mb-0">
                                        @if($summaryData['savings']['change'] > 0)
                                            <i class="bi bi-arrow-up-circle text-success"></i>
                                            <span class="text-success">{{ number_format($summaryData['savings']['change'], 1) }}%</span>
                                        @elseif($summaryData['savings']['change'] < 0)
                                            <i class="bi bi-arrow-down-circle text-danger"></i>
                                            <span class="text-danger">{{ number_format(abs($summaryData['savings']['change']), 1) }}%</span>
                                        @else
                                            <i class="bi bi-dash-circle"></i> 0%
                                        @endif
                                        respecto al período anterior
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tendencia de Ingresos y Gastos</h5>
                                    <div style="height: 300px; position: relative;">
                                        <div class="chart-loading" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.7); display: none; justify-content: center; align-items: center; z-index: 1;">
                                            <div>
                                                <div class="spinner-border text-primary mb-2" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                                <p class="text-center">Cargando datos...</p>
                                            </div>
                                        </div>
                                        <div id="no-trend-data" class="no-data-message" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: none; justify-content: center; align-items: center; z-index: 1;">
                                            <div class="text-center text-muted">
                                                <i class="bi bi-bar-chart-line display-4"></i>
                                                <p>No hay datos para mostrar en este período</p>
                                            </div>
                                        </div>
                                        <canvas id="trendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Distribución de Gastos</h5>
                                    <div style="height: 300px; position: relative;">
                                        <div class="chart-loading" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.7); display: none; justify-content: center; align-items: center; z-index: 1;">
                                            <div>
                                                <div class="spinner-border text-primary mb-2" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                                <p class="text-center">Cargando datos...</p>
                                            </div>
                                        </div>
                                        <div id="no-expense-data" class="no-data-message" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: none; justify-content: center; align-items: center; z-index: 1;">
                                            <div class="text-center text-muted">
                                                <i class="bi bi-pie-chart display-4"></i>
                                                <p>No hay gastos para mostrar en este período</p>
                                            </div>
                                        </div>
                                        <canvas id="expenseChart"></canvas>
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

@push('scripts')
<script src="{{ asset('node_modules/chart.js/dist/chart.umd.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar indicadores de carga
        const loadingIndicators = document.querySelectorAll('.chart-loading');
        loadingIndicators.forEach(indicator => {
            indicator.style.display = 'flex';
        });

        // Datos para las gráficas
        const trendData = {!! $trendData !!};
        const expenseData = {!! $expenseBreakdown !!};

        // Configuración de la gráfica de tendencia
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.labels,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: trendData.income,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Gastos',
                        data: trendData.expense,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 0.8,
                        to: 0.2,
                        loop: false
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('es-ES', {
                                        style: 'currency',
                                        currency: 'EUR'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR',
                                    maximumFractionDigits: 0
                                }).format(value);
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    }
                }
            }
        });

        // Configuración de la gráfica de distribución de gastos
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: expenseData.labels,
                datasets: [{
                    data: expenseData.data,
                    backgroundColor: expenseData.colors,
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                radius: '90%',
                animations: {
                    animateRotate: true,
                    animateScale: true
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                const percentage = ((value / total) * 100).toFixed(1);

                                return `${label}: ${new Intl.NumberFormat('es-ES', {
                                    style: 'currency',
                                    currency: 'EUR'
                                }).format(value)} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Ocultar indicadores de carga
        loadingIndicators.forEach(indicator => {
            indicator.style.display = 'none';
        });

        // Verificar si hay datos para mostrar en las gráficas
        if (trendData.labels.length === 0 ||
            (trendData.income.every(val => val === 0) && trendData.expense.every(val => val === 0))) {
            document.getElementById('no-trend-data').style.display = 'flex';
            document.getElementById('trendChart').style.display = 'none';
        }

        if (expenseData.labels.length === 0 || expenseData.data.every(val => val === 0)) {
            document.getElementById('no-expense-data').style.display = 'flex';
            document.getElementById('expenseChart').style.display = 'none';
        } else {
            // Lista de gastos por categoría
            let categoryList = '<ul class="list-group list-group-flush mt-3">';

            for (let i = 0; i < expenseData.labels.length; i++) {
                const percentage = ((expenseData.data[i] / expenseData.data.reduce((a, b) => a + b, 0)) * 100).toFixed(1);
                categoryList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-circle-fill" style="color: ${expenseData.colors[i]}"></i>
                            ${expenseData.labels[i]}
                        </span>
                        <span>
                            <strong>€${Number(expenseData.data[i]).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                            <small class="text-muted">(${percentage}%)</small>
                        </span>
                    </li>
                `;
            }

            categoryList += '</ul>';
            document.querySelector('#expenseChart').parentNode.insertAdjacentHTML('beforeend', categoryList);
        }
    });
</script>
@endpush