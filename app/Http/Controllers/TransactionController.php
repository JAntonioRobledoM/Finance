<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $transactions = auth()->user()->transactions()->latest()->paginate(15);
        $incomeCategories = auth()->user()->incomeCategories()->get();
        $expenseCategories = auth()->user()->expenseCategories()->get();

        return view('finances.transactions', [
            'transactions' => $transactions,
            'balance' => auth()->user()->balance,
            'totalIncome' => auth()->user()->incomes()->sum('amount'),
            'totalExpense' => auth()->user()->expenses()->sum('amount'),
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories
        ]);
    }

    /**
     * Store a new income transaction.
     */
    public function storeIncome(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Procesar categoría
        $category_id = null;
        $category_name = null;

        if (!empty($validated['category']) && $validated['category'] === 'new_category' && !empty($validated['new_category'])) {
            // El usuario ha seleccionado "Crear nueva categoría" y proporcionado un nombre
            $category_name = $validated['new_category'];

            // Verificar si ya existe esta categoría
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', 'income')
                ->first();

            if (!$category) {
                // Si no existe, crear nueva categoría
                $category = auth()->user()->categories()->create([
                    'name' => $category_name,
                    'type' => 'income'
                ]);
            }

            $category_id = $category->id;
        } elseif (!empty($validated['category']) && $validated['category'] !== 'new_category') {
            // El usuario ha seleccionado una categoría existente
            $category_name = $validated['category'];

            // Buscar si existe la categoría seleccionada
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', 'income')
                ->first();

            if ($category) {
                $category_id = $category->id;
            }
        }

        auth()->user()->transactions()->create([
            'type' => 'income',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $category_name,
            'category_id' => $category_id,
        ]);

        return redirect()->back()->with('success', 'Ingreso añadido correctamente!');
    }

    /**
     * Store a new expense transaction.
     */
    public function storeExpense(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Procesar categoría
        $category_id = null;
        $category_name = null;

        if (!empty($validated['category']) && $validated['category'] === 'new_category' && !empty($validated['new_category'])) {
            // El usuario ha seleccionado "Crear nueva categoría" y proporcionado un nombre
            $category_name = $validated['new_category'];

            // Verificar si ya existe esta categoría
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', 'expense')
                ->first();

            if (!$category) {
                // Si no existe, crear nueva categoría
                $category = auth()->user()->categories()->create([
                    'name' => $category_name,
                    'type' => 'expense'
                ]);
            }

            $category_id = $category->id;
        } elseif (!empty($validated['category']) && $validated['category'] !== 'new_category') {
            // El usuario ha seleccionado una categoría existente
            $category_name = $validated['category'];

            // Buscar si existe la categoría seleccionada
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', 'expense')
                ->first();

            if ($category) {
                $category_id = $category->id;
            }
        }

        auth()->user()->transactions()->create([
            'type' => 'expense',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $category_name,
            'category_id' => $category_id,
        ]);

        return redirect()->back()->with('success', 'Gasto añadido correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Acción no autorizada.');
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Transacción eliminada correctamente!');
    }

    /**
     * Show the form for editing the specified transaction category.
     */
    public function edit(Transaction $transaction): View
    {
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->route('finances.transactions')->with('error', 'Acción no autorizada.');
        }

        $categories = auth()->user()->categories()
            ->where('type', $transaction->type)
            ->get();

        return view('finances.transactions.edit', [
            'transaction' => $transaction,
            'categories' => $categories
        ]);
    }

    /**
     * Update the transaction category.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->route('finances.transactions')->with('error', 'Acción no autorizada.');
        }

        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Procesar categoría
        $category_id = null;
        $category_name = null;

        if (!empty($validated['category']) && $validated['category'] === 'new_category' && !empty($validated['new_category'])) {
            // El usuario ha seleccionado "Crear nueva categoría" y proporcionado un nombre
            $category_name = $validated['new_category'];

            // Verificar si ya existe esta categoría
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', $transaction->type)
                ->first();

            if (!$category) {
                // Si no existe, crear nueva categoría
                $category = auth()->user()->categories()->create([
                    'name' => $category_name,
                    'type' => $transaction->type
                ]);
            }

            $category_id = $category->id;
        } elseif (!empty($validated['category']) && $validated['category'] !== 'new_category') {
            // El usuario ha seleccionado una categoría existente
            $category_name = $validated['category'];

            // Buscar si existe la categoría seleccionada
            $category = auth()->user()->categories()
                ->where('name', $category_name)
                ->where('type', $transaction->type)
                ->first();

            if ($category) {
                $category_id = $category->id;
            }
        } else {
            // Si se seleccionó "Sin categoría", eliminar la categoría
            $category_name = null;
            $category_id = null;
        }

        // Actualizar la transacción
        $transaction->update([
            'category' => $category_name,
            'category_id' => $category_id,
        ]);

        return redirect()->route('finances.transactions')->with('success', 'Categoría de la transacción actualizada correctamente!');
    }
}
