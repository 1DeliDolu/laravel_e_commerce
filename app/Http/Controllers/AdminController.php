<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    public function addCategory()
    {
        return view('admin.addcategory'); // Assuming you have a view for adding categories
    }
    public function postAddCategory(Request $request)
    {
        $category = new Category();
        $category->category = $request->category;
        $category->save();
        return redirect()->back()->with('category_add', 'Category added successfully!');
    }
    public function viewCategory()
    {
        $categories = Category::all();
        return view('admin.viewcategory', compact('categories'));
    }
    /* delete category */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('category_delete', 'Category deleted successfully!');
    }

    /* edit */
    public function postUpdateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->category = $request->input('category');
        $category->save();
        return redirect()->back()->with('category_update', 'Category updated successfully!');
    }
    /* update category */
    public function updateCategoryForm($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.updatecategory', compact('category'));
    }
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->category = $request->input('category');
        $category->save();
        return redirect()->route('viewcategory')->with('category_update', 'Category updated successfully!');
    }
}
