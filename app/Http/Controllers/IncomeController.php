<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\QueryBuilder;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('category')->orderBy('received_at', 'desc')->get();
        
        return Inertia::render('Incomes.Index', [
            'incomes' => Income::all()->map(function ($income) {
                return [
                    'id' => $income->id,
                    'source' => $income->source,
                    'category_id' => $income->category_id,
                    'category_name' => $income->category ? $income->category->name : 'Keine Kategorie',
                    'amount' => (float) $income->amount, // Hier sicherstellen, dass amount eine Zahl ist
                    'received_at' => $income->received_at,
                    'type' => $income->type,
                    'recurring_interval' => $income->recurring_interval,
                ];
            }),
            'categories' => Category::where('type', 'income')->get() // Kategorien mitgeben
        ]);
    }

    public function create()
    {
        $categories = Category::where('type', 'income')->get();
        return Inertia::render('Incomes/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'received_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:one-time,recurring',
            'recurring_interval' => 'nullable|required_if:type,recurring|in:weekly,monthly,yearly',
        ]);

        Income::create($request->all());

        return redirect()->route('incomes.index')->with('success', 'Einnahme erfolgreich hinzugefügt.');
    }

    public function edit(Income $income)
    {
        $categories = Category::where('type', 'income')->get();
        return Inertia::render('Incomes/Edit', ['income' => $income, 'categories' => $categories]);
    }

    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'received_at' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:one-time,recurring',
            'recurring_interval' => 'nullable|required_if:type,recurring|in:weekly,monthly,yearly',
        ]);

        $income->update($validated);

        if (request()->inertia()) {
            return Inertia::location(route('incomes.index'));
        }
    
        return response()->json(['message' => 'Einnahme erfolgreich aktualisiert.'], 200);
    }

    public function destroy(Income $income)
    {
        $income->delete();
    
        if (request()->inertia()) {
            return Inertia::location(route('incomes.index'));
        }
    
        return response()->json(['message' => 'Einnahme erfolgreich gelöscht'], 200);
    }
    
}
