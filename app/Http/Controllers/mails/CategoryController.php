<?php

namespace App\Http\Controllers\mails;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create(['name' => $request->name]);

        return back()->with('success', 'Category created successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
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
