<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        try {
            $recentTransactions = $user->transactions()
                ->orderByRaw('transaction_date IS NULL')
                ->orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            // Fallback in case transaction_date column doesn't exist yet
            $recentTransactions = $user->transactions()
                ->latest()
                ->take(5)
                ->get();
        }
        $incomeCategories = $user->incomeCategories()->get();
        $expenseCategories = $user->expenseCategories()->get();

        // Obtener estadísticas de gastos por categoría
        $categoryExpenses = $user->expenses()
            ->whereNotNull('category_id')
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->orderByRaw('sum(amount) DESC')
            ->get();

        // Calcular gastos sin categoría
        $uncategorizedExpenses = $user->expenses()
            ->whereNull('category_id')
            ->sum('amount');

        // Obtener el presupuesto del usuario
        $budget = $user->budget()->first();
        $budgetTotal = $budget ? (float) $budget->amount : 1000.00; // Valor predeterminado si no hay presupuesto

        return view('home', [
            'balance' => $user->balance,
            'totalIncome' => $user->incomes()->sum('amount'),
            'totalExpense' => $user->expenses()->sum('amount'),
            'recentTransactions' => $recentTransactions,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
            'categoryExpenses' => $categoryExpenses,
            'uncategorizedExpenses' => $uncategorizedExpenses,
            'budgetTotal' => $budgetTotal
        ]);
    }

    /**
     * Mostrar la página de presupuesto.
     */
    public function budget()
    {
        $user = auth()->user();

        // Obtener estadísticas de gastos por categoría
        $categoryExpenses = $user->expenses()
            ->whereNotNull('category_id')
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->orderByRaw('sum(amount) DESC')
            ->get();

        // Calcular gastos sin categoría
        $uncategorizedExpenses = $user->expenses()
            ->whereNull('category_id')
            ->sum('amount');

        // Calcular el total de gastos
        $totalExpenses = $user->expenses()->sum('amount');

        // Obtener el presupuesto del usuario
        $budget = $user->budget()->first();
        $budgetTotal = $budget ? (float) $budget->amount : 1000.00; // Valor predeterminado si no hay presupuesto

        // Calcular el remanente
        $budgetRemaining = $budgetTotal - $totalExpenses;

        return view('finances.budget', [
            'categoryExpenses' => $categoryExpenses,
            'uncategorizedExpenses' => $uncategorizedExpenses,
            'totalExpenses' => $totalExpenses,
            'budgetTotal' => $budgetTotal,
            'budgetRemaining' => $budgetRemaining,
            'userBudget' => $user->budget()->first()
        ]);
    }

    /**
     * Guardar el presupuesto configurado por el usuario.
     */
    public function saveBudget(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Buscar si el usuario ya tiene un presupuesto
        $budget = $user->budget()->first();

        if ($budget) {
            // Actualizar el presupuesto existente
            $budget->update([
                'amount' => $validated['amount']
            ]);
        } else {
            // Crear un nuevo presupuesto
            $user->budget()->create([
                'amount' => $validated['amount'],
                'period' => 'monthly'
            ]);
        }

        return redirect()->route('finances.budget')->with('success', 'Presupuesto actualizado correctamente!');
    }
}
