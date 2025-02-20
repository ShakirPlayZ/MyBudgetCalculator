<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'type' => 'required|in:income,expense'
        ]);

        Category::create($validated);

        if (request()->inertia()) {
            return Inertia::location(route('categories.index'));
        }

        return response()->json(['message' => 'Kategorie erfolgreich hinzugefügt'], 201);
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'type' => 'required|in:income,expense'
        ]);

        $category->update($validated);

        if (request()->inertia()) {
            return Inertia::location(route('categories.index'));
        }

        return response()->json(['message' => 'Kategorie erfolgreich aktualisiert'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        if (request()->inertia()) {
            return Inertia::location(route('categories.index'));
        }

        return response()->json(['message' => 'Kategorie erfolgreich gelöscht'], 200);
    }
}
