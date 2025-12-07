<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        // Calcular ingresos y gastos del mes actual
        $currentMonth = now()->startOfMonth();
        $nextMonth = now()->startOfMonth()->addMonth();

        try {
            // Ingresos del mes actual
            $currentMonthIncome = $user->incomes()
                ->where(function($query) use ($currentMonth, $nextMonth) {
                    $query->whereBetween('transaction_date', [$currentMonth, $nextMonth])
                        ->orWhere(function($q) use ($currentMonth, $nextMonth) {
                            // Para transacciones sin transaction_date, usar created_at
                            $q->whereNull('transaction_date')
                               ->whereBetween('created_at', [$currentMonth, $nextMonth]);
                        });
                })
                ->sum('amount');

            // Gastos del mes actual
            $currentMonthExpense = $user->expenses()
                ->where(function($query) use ($currentMonth, $nextMonth) {
                    $query->whereBetween('transaction_date', [$currentMonth, $nextMonth])
                        ->orWhere(function($q) use ($currentMonth, $nextMonth) {
                            // Para transacciones sin transaction_date, usar created_at
                            $q->whereNull('transaction_date')
                               ->whereBetween('created_at', [$currentMonth, $nextMonth]);
                        });
                })
                ->sum('amount');
        } catch (\Exception $e) {
            // Fallback en caso de error (por ejemplo, si la columna transaction_date no existe)
            $currentMonthIncome = $user->incomes()
                ->whereBetween('created_at', [$currentMonth, $nextMonth])
                ->sum('amount');

            $currentMonthExpense = $user->expenses()
                ->whereBetween('created_at', [$currentMonth, $nextMonth])
                ->sum('amount');
        }

        return view('home', [
            'balance' => $user->balance,
            'totalIncome' => $currentMonthIncome, // Ingresos del mes actual
            'totalExpense' => $currentMonthExpense, // Gastos del mes actual
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

    /**
     * Actualizar la información del perfil del usuario.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente!');
    }

    /**
     * Actualizar la contraseña del usuario.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail('La contraseña actual es incorrecta.');
                }
            }],
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile')->with('success', 'Contraseña actualizada correctamente!');
    }
}
