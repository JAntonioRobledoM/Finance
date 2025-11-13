<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Transaction;

$user = User::first();

if (!$user) {
    echo "No hay usuarios en el sistema.";
    exit;
}

$balance = $user->balance;
$totalIncome = $user->incomes()->sum('amount');
$totalExpense = $user->expenses()->sum('amount');
$recentTransactions = $user->transactions()->latest()->take(5)->get();

$report = "
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 15px; }
        .card-blue { background-color: #007bff; color: white; }
        .card-green { background-color: #28a745; color: white; }
        .card-red { background-color: #dc3545; color: white; }
        .transaction { border-bottom: 1px solid #eee; padding: 10px 0; }
        h1, h2, h3 { margin-top: 0; }
    </style>
</head>
<body>
    <h1>Dashboard Report - " . date('Y-m-d H:i:s') . "</h1>

    <div style='display: flex; justify-content: space-between;'>
        <div class='card card-blue' style='width: 30%;'>
            <h3>Dinero Total</h3>
            <h2>€" . number_format($balance, 2) . "</h2>
        </div>

        <div class='card card-green' style='width: 30%;'>
            <h3>Ingresos</h3>
            <h2>€" . number_format($totalIncome, 2) . "</h2>
        </div>

        <div class='card card-red' style='width: 30%;'>
            <h3>Gastos</h3>
            <h2>€" . number_format($totalExpense, 2) . "</h2>
        </div>
    </div>

    <h2>Transacciones Recientes</h2>
    <div class='card'>
";

if ($recentTransactions->isEmpty()) {
    $report .= "<p>No hay transacciones recientes.</p>";
} else {
    foreach ($recentTransactions as $transaction) {
        $type = $transaction->type === 'income' ? 'Ingreso' : 'Gasto';
        $amount = $transaction->type === 'income' ? '+€' . number_format($transaction->amount, 2) : '-€' . number_format($transaction->amount, 2);
        $color = $transaction->type === 'income' ? 'green' : 'red';

        $report .= "
        <div class='transaction'>
            <div style='display: flex; justify-content: space-between;'>
                <div>
                    <strong>" . htmlspecialchars($transaction->description) . "</strong><br>
                    <small>" . ($transaction->category ?? 'Sin categoría') . "</small>
                </div>
                <div style='color: " . $color . "; font-weight: bold;'>" . $amount . "</div>
            </div>
            <div><small>" . $transaction->created_at->format('d/m/Y H:i') . "</small></div>
        </div>";
    }
}

$report .= "
    </div>

    <h2>Información de Depuración</h2>
    <div class='card'>
        <p><strong>User ID:</strong> " . $user->id . "</p>
        <p><strong>Método balance():</strong> €" . number_format($user->balance, 2) . "</p>
        <p><strong>Método incomes()->sum():</strong> €" . number_format($user->incomes()->sum('amount'), 2) . "</p>
        <p><strong>Método expenses()->sum():</strong> €" . number_format($user->expenses()->sum('amount'), 2) . "</p>
        <p><strong>Número de transacciones de ingreso:</strong> " . $user->incomes()->count() . "</p>
        <p><strong>Número de transacciones de gasto:</strong> " . $user->expenses()->count() . "</p>
        <p><strong>SQL Query para gastos:</strong> " . $user->expenses()->toSql() . "</p>
    </div>
</body>
</html>
";

file_put_contents(__DIR__ . '/dashboard_report.html', $report);

echo "Reporte generado exitosamente en dashboard_report.html";