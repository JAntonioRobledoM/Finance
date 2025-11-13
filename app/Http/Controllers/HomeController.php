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
        $recentTransactions = $user->transactions()->latest()->take(5)->get();

        return view('home', [
            'balance' => $user->balance,
            'totalIncome' => $user->incomes()->sum('amount'),
            'totalExpense' => $user->expenses()->sum('amount'),
            'recentTransactions' => $recentTransactions
        ]);
    }
}
