<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

        return view('finances.transactions', [
            'transactions' => $transactions,
            'balance' => auth()->user()->balance,
            'totalIncome' => auth()->user()->incomes()->sum('amount'),
            'totalExpense' => auth()->user()->expenses()->sum('amount')
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
        ]);

        auth()->user()->transactions()->create([
            'type' => 'income',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? 'General',
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
        ]);

        auth()->user()->transactions()->create([
            'type' => 'expense',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? 'General',
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
}
