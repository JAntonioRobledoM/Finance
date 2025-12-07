<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\SavingsContribution;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SavingsContributionController extends Controller
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
     * Store a newly created contribution in storage.
     */
    public function store(Request $request, SavingsGoal $savingsGoal): RedirectResponse
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'contribution_date' => 'required|date',
            'type' => 'required|in:deposit,withdrawal',
        ]);

        // Verificar si es un retiro, que haya suficiente dinero
        if ($validated['type'] === 'withdrawal' && $savingsGoal->current_amount < $validated['amount']) {
            return back()->with('error', 'No hay suficiente dinero en esta meta para realizar este retiro.');
        }

        DB::beginTransaction();

        try {
            // Crear la contribución
            $contribution = $savingsGoal->contributions()->create([
                'user_id' => auth()->id(),
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'contribution_date' => $validated['contribution_date'],
                'type' => $validated['type'],
            ]);

            // Actualizar el monto actual de la meta
            $newAmount = $validated['type'] === 'deposit'
                ? $savingsGoal->current_amount + $validated['amount']
                : $savingsGoal->current_amount - $validated['amount'];

            $savingsGoal->current_amount = $newAmount;

            // Si alcanzamos o superamos el objetivo, marcar como completado
            if ($newAmount >= $savingsGoal->target_amount && $savingsGoal->status === 'active') {
                $savingsGoal->status = 'completed';
            }

            $savingsGoal->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ha ocurrido un error al procesar la contribución: ' . $e->getMessage());
        }

        return redirect()->route('finances.savings.show', $savingsGoal)
            ->with('success', '¡Contribución registrada correctamente!');
    }

    /**
     * Remove the specified contribution from storage.
     */
    public function destroy(SavingsContribution $contribution): RedirectResponse
    {
        // Verificar que la contribución pertenece al usuario autenticado
        if ($contribution->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $savingsGoal = $contribution->savingsGoal;

        DB::beginTransaction();

        try {
            // Actualizar el monto actual de la meta
            $newAmount = $contribution->type === 'deposit'
                ? $savingsGoal->current_amount - $contribution->amount
                : $savingsGoal->current_amount + $contribution->amount;

            // No permitir montos negativos
            $savingsGoal->current_amount = max(0, $newAmount);

            // Actualizar el estado si es necesario
            if ($savingsGoal->status === 'completed' && $newAmount < $savingsGoal->target_amount) {
                $savingsGoal->status = 'active';
            }

            $savingsGoal->save();

            // Eliminar la contribución
            $contribution->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ha ocurrido un error al eliminar la contribución: ' . $e->getMessage());
        }

        return redirect()->route('finances.savings.show', $savingsGoal)
            ->with('success', '¡Contribución eliminada correctamente!');
    }
}
