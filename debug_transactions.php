<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Transaction;
use App\Models\User;

$user = User::first();

if (!$user) {
    echo "No hay usuarios en el sistema.\n";
    exit;
}

echo "Usuario: " . $user->name . " (ID: " . $user->id . ")\n";
echo "Balance: " . $user->balance . "\n";

echo "=== TRANSACCIONES ===\n";
$transactions = Transaction::where('user_id', $user->id)->get();

if ($transactions->isEmpty()) {
    echo "No hay transacciones para este usuario.\n";
} else {
    foreach ($transactions as $transaction) {
        echo "ID: " . $transaction->id . "\n";
        echo "Tipo: " . $transaction->type . "\n";
        echo "Cantidad: " . $transaction->amount . "\n";
        echo "Descripción: " . $transaction->description . "\n";
        echo "Categoría: " . ($transaction->category ?? 'Sin categoría') . "\n";
        echo "Fecha: " . $transaction->created_at . "\n";
        echo "------------------\n";
    }
}

echo "\n=== RESUMEN ===\n";
echo "Total Ingresos: " . $user->incomes()->sum('amount') . "\n";
echo "Total Gastos: " . $user->expenses()->sum('amount') . "\n";
echo "Número de transacciones de ingreso: " . $user->incomes()->count() . "\n";
echo "Número de transacciones de gasto: " . $user->expenses()->count() . "\n";