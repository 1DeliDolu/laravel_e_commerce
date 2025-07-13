<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display the home page with products
     */
    public function index()
    {
        // Get featured/latest products (limit to 12 for homepage)
        $products = Product::with('category')
            ->where('product_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        // Get all categories for navigation
        $categories = Category::all();

        return view('index', compact('products', 'categories'));
    }

    /**
     * Display product detail page
     */
    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::with('category')
            ->where('product_category', $product->product_category)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('product_detail', compact('product', 'relatedProducts'));
    }
}
