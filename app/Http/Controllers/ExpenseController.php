<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function dashboardData()
    {
        // Alle Ausgaben mit Name & Datum abrufen
        $expenses = Expense::select('description', 'amount', 'paid_at')
            ->orderBy('paid_at', 'asc')
            ->get();
    
        return response()->json($expenses);
    }
    

    public function index()
    {
        return Inertia::render('Expenses.Index', [
            'expenses' => Expense::with('category')->orderBy('paid_at', 'desc')->get()->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'description' => $expense->description,
                    'amount' => (float) $expense->amount,
                    'paid_at' => $expense->paid_at,
                    'category_id' => $expense->category_id,
                    'category_name' => $expense->category ? $expense->category->name : 'Keine Kategorie',
                    'type' => $expense->type,
                    'recurring_interval' => $expense->recurring_interval,
                ];
            }),
            'categories' => Category::where('type', 'expense')->get() // Kategorien mitgeben
        ]);
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')->get();
        return Inertia::render('Expenses/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:one-time,recurring',
            'recurring_interval' => 'nullable|required_if:type,recurring|in:weekly,monthly,yearly',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Ausgabe erfolgreich hinzugefügt.');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::where('type', 'expense')->get();
        return Inertia::render('Expenses/Edit', ['expense' => $expense, 'categories' => $categories]);
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:one-time,recurring',
            'recurring_interval' => 'nullable|required_if:type,recurring|in:weekly,monthly,yearly',
        ]);

        $expense->update($validated);

        if (request()->inertia()) {
            return Inertia::location(route('expenses.index'));
        }
    
        return response()->json(['message' => 'Erfolgreich aktualisiert.'], 200);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        if (request()->inertia()) {
            return Inertia::location(route('expenses.index'));
        }
    
        return response()->json(['message' => 'Einnahme erfolgreich gelöscht'], 200);
    }
}
