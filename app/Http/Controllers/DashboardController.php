<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Income::sum('amount');
        $totalExpense = Expense::sum('amount');
        $balance = $totalIncome - $totalExpense;

        $monthlyIncome = Income::selectRaw('MONTH(received_at) as month, SUM(amount) as total')
            ->groupByRaw('MONTH(received_at)')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => (float) $item->total]; // Stelle sicher, dass die Werte als Float gespeichert werden
            })
            ->toArray();
    
        $monthlyExpense = Expense::whereNotNull('paid_at')
            ->selectRaw('MONTH(paid_at) as month, COALESCE(SUM(amount), 0) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
    

        return Inertia::render('Dashboard', [
            'totalIncome' => (float) Income::sum('amount'),
            'totalExpense' => (float) Expense::sum('amount'),
            'balance' => (float) (Income::sum('amount') - Expense::sum('amount')),
            'monthlyIncome' => Income::selectRaw('MONTH(received_at) as month, SUM(amount) as total')
                ->groupByRaw('MONTH(received_at)')
                ->pluck('total', 'month')
                ->toArray(),
            'monthlyExpense' => Expense::selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
                ->groupByRaw('MONTH(paid_at)')
                ->pluck('total', 'month')
                ->toArray(),
            'routes' => [
                'dashboard' => url('/dashboard'),
                'incomes' => url('/incomes'),
                'expenses' => url('/expenses'),
            ],
        ]);
    }
}
