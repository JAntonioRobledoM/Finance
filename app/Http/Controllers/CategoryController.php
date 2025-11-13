<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
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
     * Display a listing of the categories.
     */
    public function index(): View
    {
        $incomeCategories = auth()->user()->incomeCategories()->get();
        $expenseCategories = auth()->user()->expenseCategories()->get();

        return view('finances.categories', [
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories
        ]);
    }

    /**
     * Store a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        // Comprobar si ya existe
        $exists = auth()->user()->categories()
            ->where('name', $validated['name'])
            ->where('type', $validated['type'])
            ->exists();

        if (!$exists) {
            auth()->user()->categories()->create([
                'name' => $validated['name'],
                'type' => $validated['type'],
            ]);
            return redirect()->back()->with('success', 'Categoría creada correctamente!');
        }

        return redirect()->back()->with('error', 'Esta categoría ya existe!');
    }

    /**
     * Delete the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Verificar que la categoría pertenece al usuario actual
        if ($category->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Acción no autorizada.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Categoría eliminada correctamente!');
    }
}
