<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['todos' => function ($query) {
            $query->where('user_id', Auth::id()); 
        }])
        ->where('user_id', Auth::id()) 
        ->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if (Auth::id() == $category->user_id) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        } else {
        return redirect()->route('category.index')->with('danger', 'You are not authorized to delete this category!');
        }
    }
}