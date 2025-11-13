<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;

$user = User::first();

if (!$user) {
    echo "No hay usuarios en el sistema.\n";
    exit;
}

// Crear una categoría para el gasto (o usar una existente)
$category = Category::firstOrCreate(
    ['user_id' => $user->id, 'name' => 'Comida', 'type' => 'expense'],
    ['user_id' => $user->id, 'name' => 'Comida', 'type' => 'expense']
);

$transaction = Transaction::create([
    'user_id' => $user->id,
    'type' => 'expense',
    'amount' => 35.75,
    'description' => 'Supermercado',
    'category' => $category->name,
    'category_id' => $category->id,
]);

if ($transaction) {
    echo "Gasto de categoría creado exitosamente: ID = " . $transaction->id . "\n";
    echo "Categoría: " . $category->name . "\n";
} else {
    echo "Error al crear el gasto.\n";
}

echo "Total de gastos para el usuario: " . $user->expenses()->sum('amount') . "\n";