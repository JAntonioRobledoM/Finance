<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de análisis financieros.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $period = $request->input('period', '30days');
        $validPeriods = ['30days', '90days', '180days', '365days', 'year'];

        if (!in_array($period, $validPeriods)) {
            $period = '30days';
        }

        // Obtener los datos de resumen
        $summaryData = $this->getSummaryData($period);

        // Obtener los datos para la gráfica de tendencia
        $trendData = $this->getTrendData($period);

        // Obtener los datos para la gráfica de distribución de gastos
        $expenseBreakdown = $this->getExpenseBreakdown($period);

        return view('finances.analytics', [
            'period' => $period,
            'summaryData' => $summaryData,
            'trendData' => json_encode($trendData),
            'expenseBreakdown' => json_encode($expenseBreakdown)
        ]);
    }

    /**
     * Obtener datos de resumen según el período seleccionado.
     *
     * @param  string  $period
     * @return array
     */
    private function getSummaryData(string $period): array
    {
        $user = auth()->user();
        list($startDate, $endDate) = $this->getPeriodDates($period);
        $previousStartDate = clone $startDate;
        $previousEndDate = clone $endDate;

        // Calcular período anterior de la misma duración
        $durationInDays = $startDate->diffInDays($endDate);
        $previousStartDate->subDays($durationInDays);
        $previousEndDate->subDays($durationInDays);

        // Obtener datos del período actual
        $currentIncome = $this->getPeriodAmount($user, 'income', $startDate, $endDate);
        $currentExpense = $this->getPeriodAmount($user, 'expense', $startDate, $endDate);
        $currentSavings = $currentIncome - $currentExpense;

        // Obtener datos del período anterior
        $previousIncome = $this->getPeriodAmount($user, 'income', $previousStartDate, $previousEndDate);
        $previousExpense = $this->getPeriodAmount($user, 'expense', $previousStartDate, $previousEndDate);
        $previousSavings = $previousIncome - $previousExpense;

        // Calcular cambios porcentuales
        $incomeChange = $previousIncome > 0 ? (($currentIncome - $previousIncome) / $previousIncome) * 100 : 0;
        $expenseChange = $previousExpense > 0 ? (($currentExpense - $previousExpense) / $previousExpense) * 100 : 0;
        $savingsChange = $previousSavings > 0 ? (($currentSavings - $previousSavings) / $previousSavings) * 100 : 0;

        return [
            'income' => [
                'current' => $currentIncome,
                'previous' => $previousIncome,
                'change' => $incomeChange
            ],
            'expense' => [
                'current' => $currentExpense,
                'previous' => $previousExpense,
                'change' => $expenseChange
            ],
            'savings' => [
                'current' => $currentSavings,
                'previous' => $previousSavings,
                'change' => $savingsChange
            ]
        ];
    }

    /**
     * Obtener datos de tendencia para gráfica según el período.
     *
     * @param  string  $period
     * @return array
     */
    private function getTrendData(string $period): array
    {
        $user = auth()->user();
        list($startDate, $endDate) = $this->getPeriodDates($period);

        $result = [
            'labels' => [],
            'income' => [],
            'expense' => []
        ];

        // Determinar el intervalo según el período
        $interval = $this->getIntervalForPeriod($period);
        $current = clone $startDate;

        while ($current->lte($endDate)) {
            $intervalEnd = clone $current;

            if ($interval === 'day') {
                $result['labels'][] = $current->format('d M');
                $intervalEnd->endOfDay();
            } elseif ($interval === 'week') {
                $result['labels'][] = 'Semana ' . $current->weekOfYear;
                $intervalEnd = (clone $current)->addDays(6)->endOfDay();
            } else {  // month
                $result['labels'][] = $current->format('M Y');
                $intervalEnd = (clone $current)->endOfMonth();
            }

            // Obtener ingresos y gastos para este intervalo
            $income = $this->getPeriodAmount($user, 'income', $current, $intervalEnd);
            $expense = $this->getPeriodAmount($user, 'expense', $current, $intervalEnd);

            $result['income'][] = $income;
            $result['expense'][] = $expense;

            // Avanzar al siguiente intervalo
            if ($interval === 'day') {
                $current->addDay();
            } elseif ($interval === 'week') {
                $current->addDays(7);
            } else {  // month
                $current->addMonth();
            }
        }

        return $result;
    }

    /**
     * Obtener desglose de gastos por categoría según el período.
     *
     * @param  string  $period
     * @return array
     */
    private function getExpenseBreakdown(string $period): array
    {
        $user = auth()->user();
        list($startDate, $endDate) = $this->getPeriodDates($period);

        // Obtener gastos por categoría
        try {
            $categoryExpenses = $user->expenses()
                ->whereNotNull('category_id')
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate])
                        ->orWhere(function($q) use ($startDate, $endDate) {
                            $q->whereNull('transaction_date')
                               ->whereBetween('created_at', [$startDate, $endDate]);
                        });
                })
                ->selectRaw('category, sum(amount) as total')
                ->groupBy('category')
                ->orderByRaw('sum(amount) DESC')
                ->get();
        } catch (\Exception $e) {
            $categoryExpenses = $user->expenses()
                ->whereNotNull('category_id')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('category, sum(amount) as total')
                ->groupBy('category')
                ->orderByRaw('sum(amount) DESC')
                ->get();
        }

        // Obtener gastos sin categoría
        try {
            $uncategorizedExpense = $user->expenses()
                ->whereNull('category_id')
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate])
                        ->orWhere(function($q) use ($startDate, $endDate) {
                            $q->whereNull('transaction_date')
                               ->whereBetween('created_at', [$startDate, $endDate]);
                        });
                })
                ->sum('amount');
        } catch (\Exception $e) {
            $uncategorizedExpense = $user->expenses()
                ->whereNull('category_id')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
        }

        $labels = [];
        $data = [];
        $colors = [];

        // Procesar categorías
        foreach ($categoryExpenses as $expense) {
            $labels[] = $expense->category;
            $data[] = $expense->total;
            $colors[] = $this->generateColorForCategory($expense->category);
        }

        // Añadir gastos sin categoría
        if ($uncategorizedExpense > 0) {
            $labels[] = 'Sin categoría';
            $data[] = $uncategorizedExpense;
            $colors[] = '#6c757d'; // Gris para gastos sin categoría
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors
        ];
    }

    /**
     * Obtener fecha de inicio y fin según el período seleccionado.
     *
     * @param  string  $period
     * @return array
     */
    private function getPeriodDates(string $period): array
    {
        $now = Carbon::now();
        $endDate = clone $now;

        switch ($period) {
            case '30days':
                $startDate = $now->copy()->subDays(30)->startOfDay();
                break;
            case '90days':
                $startDate = $now->copy()->subDays(90)->startOfDay();
                break;
            case '180days':
                $startDate = $now->copy()->subDays(180)->startOfDay();
                break;
            case '365days':
                $startDate = $now->copy()->subDays(365)->startOfDay();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->subDays(30)->startOfDay();
        }

        return [$startDate, $endDate];
    }

    /**
     * Determinar el intervalo adecuado según el período seleccionado.
     *
     * @param  string  $period
     * @return string
     */
    private function getIntervalForPeriod(string $period): string
    {
        switch ($period) {
            case '30days':
                return 'day';
            case '90days':
                return 'week';
            case '180days':
            case '365days':
            case 'year':
                return 'month';
            default:
                return 'day';
        }
    }

    /**
     * Obtener cantidad total de ingresos o gastos en un período.
     *
     * @param  \App\Models\User  $user
     * @param  string  $type
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return float
     */
    private function getPeriodAmount($user, string $type, Carbon $startDate, Carbon $endDate): float
    {
        $query = $type === 'income' ? $user->incomes() : $user->expenses();

        try {
            return $query
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate])
                        ->orWhere(function($q) use ($startDate, $endDate) {
                            $q->whereNull('transaction_date')
                                ->whereBetween('created_at', [$startDate, $endDate]);
                        });
                })
                ->sum('amount');
        } catch (\Exception $e) {
            // Fallback en caso de error (por ejemplo, si la columna transaction_date no existe)
            return $query
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
        }
    }

    /**
     * Generar color para categoría.
     *
     * @param  string  $category
     * @return string
     */
    private function generateColorForCategory(string $category): string
    {
        // Mapeo de categorías comunes a colores específicos
        $colorMap = [
            'Alimentación' => '#FF5733',
            'Comida' => '#FF5733',
            'Restaurantes' => '#FF9A33',
            'Vivienda' => '#33A8FF',
            'Alquiler' => '#33A8FF',
            'Hipoteca' => '#3377FF',
            'Transporte' => '#33FF57',
            'Salud' => '#FF3377',
            'Ocio' => '#A833FF',
            'Entretenimiento' => '#A833FF',
            'Educación' => '#FFC133',
            'Servicios' => '#33FFC1',
            'Facturas' => '#33FFC1',
            'Ropa' => '#FF33A8',
            'Viajes' => '#C1FF33',
            'Suscripciones' => '#8033FF',
            'Impuestos' => '#FF3333',
            'Regalos' => '#FF33C1',
            'Tecnología' => '#33C1FF',
            'Mascotas' => '#FF8033',
            'Inversiones' => '#33FF8D',
            'Ahorro' => '#3353FF',
            'Salario' => '#33FF33',
            'Ingresos extras' => '#A8FF33',
            'Freelance' => '#FFCC33'
        ];

        if (array_key_exists($category, $colorMap)) {
            return $colorMap[$category];
        }

        // Si la categoría no está en el mapeo, generar un color basado en el hash del nombre
        $hash = crc32($category);
        $hue = $hash % 360;

        return "hsl($hue, 70%, 60%)";
    }

    /**
     * Obtener datos para la API de análisis (formato JSON).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnalyticsData(Request $request): JsonResponse
    {
        $period = $request->input('period', '30days');
        $validPeriods = ['30days', '90days', '180days', '365days', 'year'];

        if (!in_array($period, $validPeriods)) {
            $period = '30days';
        }

        $summaryData = $this->getSummaryData($period);
        $trendData = $this->getTrendData($period);
        $expenseBreakdown = $this->getExpenseBreakdown($period);

        return response()->json([
            'summary' => $summaryData,
            'trend' => $trendData,
            'expenseBreakdown' => $expenseBreakdown
        ]);
    }
}