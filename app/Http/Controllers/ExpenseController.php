<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')->orderBy('paid_at', 'desc')->get();
        #return Inertia::render('Expenses/Index', ['expenses' => $expenses]);
        return Inertia::render('Expenses.Index', [
            'expenses' => Expense::all()->map(function ($expenses) {
                return [
                    'id' => $expenses->id,
                    'description' => $expenses->description,
                    'amount' => (float) $expenses->amount,
                    'paid_at' => $expenses->paid_at,
                ];
            }),
        ]);
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')->get();
        return Inertia::render('Expenses/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
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
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Ausgabe erfolgreich aktualisiert.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Ausgabe erfolgreich gelöscht.');
    }
}
