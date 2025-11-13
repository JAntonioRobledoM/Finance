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

$transaction = Transaction::create([
    'user_id' => $user->id,
    'type' => 'expense',
    'amount' => 25.50,
    'description' => 'Prueba de gasto',
]);

if ($transaction) {
    echo "Gasto de prueba creado exitosamente: ID = " . $transaction->id . "\n";
} else {
    echo "Error al crear el gasto de prueba.\n";
}

echo "Total de gastos para el usuario: " . $user->expenses()->sum('amount') . "\n";