<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;

class AdminController extends Controller
{
    public function addCategory()
    {
        return view('admin.add_category'); // Assuming you have a view for adding categories
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
        return view('admin.view_category', compact('categories'));
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
        return view('admin.update_category', compact('category'));
    }
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->category = $request->input('category');
        $category->save();
        return redirect()->route('view_category')->with('category_update', 'Category updated successfully!');
    }

    /* add product */
    public function addProduct() {
        $categories = Category::all(); // Tüm kategorileri al
        return view('admin.add_product', compact('categories')); // View'e gönder
    }

    public function postAddProduct(Request $request) {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|exists:categories,id',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $product = new Product();
            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->product_quantity = $request->product_quantity;
            $product->product_price = $request->product_price;
            $product->product_category = $request->product_category;

            // Handle multiple image uploads
            $imagePaths = [];
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $image) {
                    // Create directory if it doesn't exist
                    $uploadPath = public_path('uploads/products');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    // Generate unique filename
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move image to public/uploads/products directory
                    $image->move($uploadPath, $imageName);

                    // Store relative path
                    $imagePaths[] = 'uploads/products/' . $imageName;
                }
            }

            // Store image paths as JSON, or empty array if no images
            $product->product_images = json_encode($imagePaths);
            $product->save();

            return redirect()->back()->with('product_add', 'Ürün başarıyla eklendi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('product_error', 'Ürün eklenirken hata oluştu: ' . $e->getMessage());
        }
    }

    /* view product */
    public function viewProduct()
    {
        $products = Product::with('category')->paginate(10); // 10 products per page
        return view('admin.view_product', compact('products'));
    }

    /* edit product */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.update_product', compact('product', 'categories'));
    }

    /* update product */
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|exists:categories,id',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|string'
        ]);

        try {
            $product = Product::findOrFail($id);

            // Get original images before update
            $originalImages = is_string($product->product_images)
                ? json_decode($product->product_images, true) ?? []
                : $product->product_images ?? [];

            // Handle existing images from form
            $existingImages = [];
            if ($request->existing_images) {
                $existingImages = json_decode($request->existing_images, true) ?: [];
            }

            // Find images that were removed (exist in original but not in existing)
            $removedImages = array_diff($originalImages, $existingImages);

            // Delete removed images from file system
            if (!empty($removedImages)) {
                foreach ($removedImages as $imagePath) {
                    $fullPath = public_path($imagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath); // Delete the physical file
                    }
                }
            }

            $product->product_title = $request->product_title;
            $product->product_description = $request->product_description;
            $product->product_quantity = $request->product_quantity;
            $product->product_price = $request->product_price;
            $product->product_category = $request->product_category;

            // Handle new image uploads
            $newImagePaths = [];
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $image) {
                    // Create directory if it doesn't exist
                    $uploadPath = public_path('uploads/products');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    // Generate unique filename
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Move image to public/uploads/products directory
                    $image->move($uploadPath, $imageName);

                    // Store relative path
                    $newImagePaths[] = 'uploads/products/' . $imageName;
                }
            }

            // Merge existing and new images
            $allImages = array_merge($existingImages, $newImagePaths);
            $product->product_images = json_encode($allImages);

            $product->save();

            return redirect()->route('view_product')->with('product_update', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('product_error', 'Error updating product: ' . $e->getMessage());
        }
    }

    /* delete product */
    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete associated images from storage
            if ($product->product_images) {
                $images = is_string($product->product_images)
                    ? json_decode($product->product_images, true)
                    : $product->product_images;

                if (is_array($images) && !empty($images)) {
                    foreach ($images as $imagePath) {
                        $fullPath = public_path($imagePath);
                        if (file_exists($fullPath)) {
                            unlink($fullPath); // Delete the physical file
                        }
                    }
                }
            }

            // Delete the product record
            $product->delete();

            return redirect()->back()->with('product_delete', 'Product and associated images deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('product_error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /* view order */
    public function viewOrder()
    {
        // For now, return a simple view or redirect
        // You can implement order functionality later
        return view('admin.view_order');
    }

    /**
     * Admin dashboard
     */
    public function adminDashboard()
    {
        // Dashboard için gerekli verileri alabilirsiniz
        $totalCustomers = \App\Models\Customer::count();
        $totalProducts = \App\Models\Product::count();
        $totalCategories = \App\Models\Category::count();
        $totalOrders = 0; // Order model eklendiğinde güncellenir

        return view('admin.admin_dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalCategories',
            'totalOrders'
        ));
    }

}
