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
                    'amount' => (float) $income->amount, // 🔥 Hier sicherstellen, dass amount eine Zahl ist
                    'received_at' => $income->received_at,
                ];
            }),
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
