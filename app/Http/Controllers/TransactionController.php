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
    public function index(Request $request): View
    {
        // Obtener el número de elementos por página desde la solicitud
        $perPage = $request->query('perPage', 15);

        // Asegurar que perPage sea un valor permitido
        if (!in_array($perPage, [15, 25, 50])) {
            $perPage = 15;
        }

        try {
            $transactions = auth()->user()->transactions()
                ->orderByRaw('transaction_date IS NULL')
                ->orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->paginate($perPage);
        } catch (\Exception $e) {
            // Fallback in case transaction_date column doesn't exist yet
            $transactions = auth()->user()->transactions()
                ->latest()
                ->paginate($perPage);
        }
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
            'transaction_date' => 'nullable|date',
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

        // Prepare transaction data
        $transactionData = [
            'type' => 'income',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $category_name,
            'category_id' => $category_id,
        ];

        // Only include transaction_date if it's provided and the column exists
        if (isset($validated['transaction_date'])) {
            try {
                // Use a more direct way to check if the column exists in the schema
                $columnExists = \Schema::hasColumn('transactions', 'transaction_date');

                // If column exists in schema, include it in the update
                if ($columnExists) {
                    $transactionData['transaction_date'] = $validated['transaction_date'];
                }
            } catch (\Exception $e) {
                // If there's an error checking the schema, use the fallback approach
                try {
                    // Test if transaction_date column exists by trying to set it on a model
                    $testTransaction = new Transaction();
                    $testTransaction->transaction_date = $validated['transaction_date'];

                    // If we get here, the column exists
                    $transactionData['transaction_date'] = $validated['transaction_date'];
                } catch (\Exception $innerException) {
                    // Column doesn't exist, ignore it
                }
            }
        }

        // Create the transaction with the prepared data
        try {
            auth()->user()->transactions()->create($transactionData);
        } catch (\Exception $e) {
            // If creation fails due to column issues, try without transaction_date
            if (isset($transactionData['transaction_date'])) {
                unset($transactionData['transaction_date']);
                auth()->user()->transactions()->create($transactionData);
            } else {
                // If it fails for other reasons, throw the original exception
                throw $e;
            }
        }

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
            'transaction_date' => 'nullable|date',
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

        // Prepare transaction data
        $transactionData = [
            'type' => 'expense',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $category_name,
            'category_id' => $category_id,
        ];

        // Only include transaction_date if it's provided and the column exists
        if (isset($validated['transaction_date'])) {
            try {
                // Use a more direct way to check if the column exists in the schema
                $columnExists = \Schema::hasColumn('transactions', 'transaction_date');

                // If column exists in schema, include it in the update
                if ($columnExists) {
                    $transactionData['transaction_date'] = $validated['transaction_date'];
                }
            } catch (\Exception $e) {
                // If there's an error checking the schema, use the fallback approach
                try {
                    // Test if transaction_date column exists by trying to set it on a model
                    $testTransaction = new Transaction();
                    $testTransaction->transaction_date = $validated['transaction_date'];

                    // If we get here, the column exists
                    $transactionData['transaction_date'] = $validated['transaction_date'];
                } catch (\Exception $innerException) {
                    // Column doesn't exist, ignore it
                }
            }
        }

        // Create the transaction with the prepared data
        try {
            auth()->user()->transactions()->create($transactionData);
        } catch (\Exception $e) {
            // If creation fails due to column issues, try without transaction_date
            if (isset($transactionData['transaction_date'])) {
                unset($transactionData['transaction_date']);
                auth()->user()->transactions()->create($transactionData);
            } else {
                // If it fails for other reasons, throw the original exception
                throw $e;
            }
        }

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
     * Update the transaction.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        // Check if the transaction belongs to the authenticated user
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->route('finances.transactions')->with('error', 'Acción no autorizada.');
        }

        $validated = $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
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
        // Prepare update data
        $updateData = [
            'category' => $category_name,
            'category_id' => $category_id,
            'amount' => $validated['amount'],
        ];

        // Only include transaction_date if it's provided and we're not in "compatibility mode"
        if (isset($validated['transaction_date'])) {
            try {
                // Use a more direct way to check if the column exists in the schema
                $columnExists = \Schema::hasColumn('transactions', 'transaction_date');

                // If column exists in schema, include it in the update
                if ($columnExists) {
                    $updateData['transaction_date'] = $validated['transaction_date'];
                }
            } catch (\Exception $e) {
                // If there's an error checking the schema, use the fallback approach
                try {
                    // Test if transaction_date column exists by trying to set it on a model
                    $testTransaction = new Transaction();
                    $testTransaction->transaction_date = $validated['transaction_date'];

                    // If we get here, the column exists, so include it in the update
                    $updateData['transaction_date'] = $validated['transaction_date'];
                } catch (\Exception $innerException) {
                    // Column doesn't exist, ignore it
                }
            }
        }

        // Update the transaction with the prepared data
        try {
            $transaction->update($updateData);
        } catch (\Exception $e) {
            // If the update fails due to column issues, try with just the category data
            if (isset($updateData['transaction_date'])) {
                unset($updateData['transaction_date']);
                $transaction->update($updateData);
            } else {
                // If it fails for other reasons, throw the original exception
                throw $e;
            }
        }

        return redirect()->route('finances.transactions')->with('success', 'Transacción actualizada correctamente!');
    }
}
