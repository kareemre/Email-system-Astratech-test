<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Keyword;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $category = Category::create($request->only('name'));
        $this->syncKeywords($category, $request->keywords);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->only('name'));
        $this->syncKeywords($category, $request->keywords);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    private function syncKeywords(Category $category, $keywords)
    {
        $keywordsArray = array_filter(array_map('trim', explode(',', $keywords)));
        $keywordIds = [];
        
        foreach ($keywordsArray as $keyword) {
            $keywordModel = Keyword::firstOrCreate(['keyword' => $keyword]);
            $keywordIds[] = $keywordModel->id;
        }

        $category->keywords()->sync($keywordIds);
    }
}
