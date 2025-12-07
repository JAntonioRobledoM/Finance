<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavingsGoalController extends Controller
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
     * Display a listing of the savings goals.
     */
    public function index(): View
    {
        $user = auth()->user();
        $activeGoals = $user->savingsGoals()
            ->where('status', 'active')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $completedGoals = $user->savingsGoals()
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $pausedGoals = $user->savingsGoals()
            ->where('status', 'paused')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('finances.savings', [
            'activeGoals' => $activeGoals,
            'completedGoals' => $completedGoals,
            'pausedGoals' => $pausedGoals,
            'totalSaved' => $activeGoals->sum('current_amount') + $completedGoals->sum('current_amount'),
            'totalTarget' => $activeGoals->sum('target_amount') + $completedGoals->sum('target_amount') + $pausedGoals->sum('target_amount')
        ]);
    }

    /**
     * Show the form for creating a new savings goal.
     */
    public function create(): View
    {
        return view('finances.savings.create');
    }

    /**
     * Store a newly created savings goal in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'target_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'nullable|integer|min:1|max:5',
        ]);

        // Establecer prioridad por defecto si no se proporciona
        if (!isset($validated['priority'])) {
            $validated['priority'] = 3;
        }

        // Crear la meta de ahorro
        $savingsGoal = auth()->user()->savingsGoals()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'current_amount' => 0, // Comienza con 0
            'status' => 'active',
            'start_date' => $validated['start_date'],
            'target_date' => $validated['target_date'],
            'priority' => $validated['priority'],
        ]);

        return redirect()->route('finances.savings.show', $savingsGoal)
            ->with('success', '¡Meta de ahorro creada correctamente!');
    }

    /**
     * Display the specified savings goal.
     */
    public function show(SavingsGoal $savingsGoal): View
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        // Obtener las contribuciones ordenadas por fecha
        $contributions = $savingsGoal->contributions()
            ->orderBy('contribution_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('finances.savings.show', [
            'goal' => $savingsGoal,
            'contributions' => $contributions
        ]);
    }

    /**
     * Show the form for editing the specified savings goal.
     */
    public function edit(SavingsGoal $savingsGoal): View
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        return view('finances.savings.edit', [
            'goal' => $savingsGoal
        ]);
    }

    /**
     * Update the specified savings goal in storage.
     */
    public function update(Request $request, SavingsGoal $savingsGoal): RedirectResponse
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:' . $savingsGoal->current_amount,
            'status' => 'required|in:active,paused,completed',
            'target_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'required|integer|min:1|max:5',
        ]);

        // Actualizar la meta de ahorro
        $savingsGoal->update($validated);

        return redirect()->route('finances.savings.show', $savingsGoal)
            ->with('success', '¡Meta de ahorro actualizada correctamente!');
    }

    /**
     * Remove the specified savings goal from storage.
     */
    public function destroy(SavingsGoal $savingsGoal): RedirectResponse
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        // Eliminar la meta y sus contribuciones (cascade)
        $savingsGoal->delete();

        return redirect()->route('finances.savings')
            ->with('success', '¡Meta de ahorro eliminada correctamente!');
    }

    /**
     * Mark a savings goal as completed.
     */
    public function complete(SavingsGoal $savingsGoal): RedirectResponse
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        // Marcar como completada
        $savingsGoal->update(['status' => 'completed']);

        return redirect()->route('finances.savings')
            ->with('success', '¡Meta de ahorro completada correctamente!');
    }

    /**
     * Change the status of a savings goal (active/paused).
     */
    public function changeStatus(Request $request, SavingsGoal $savingsGoal): RedirectResponse
    {
        // Verificar que la meta pertenece al usuario autenticado
        if ($savingsGoal->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'status' => 'required|in:active,paused',
        ]);

        // Actualizar el estado
        $savingsGoal->update(['status' => $validated['status']]);

        return redirect()->route('finances.savings')
            ->with('success', '¡Estado de la meta de ahorro actualizado correctamente!');
    }
}
