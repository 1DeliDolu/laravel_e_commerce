<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->product_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock!'
            ], 400);
        }

        $customerId = Auth::guard('customer')->id();
        $sessionId = $this->getSessionId();

        // Check if item already exists in cart
        $existingCart = Cart::where('product_id', $request->product_id)
            ->where(function($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($existingCart) {
            // Update quantity
            $newQuantity = $existingCart->quantity + $request->quantity;

            if ($product->product_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more items. Stock limit reached!'
                ], 400);
            }

            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            Cart::create([
                'customer_id' => $customerId,
                'session_id' => $customerId ? null : $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->product_price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount()
    {
        $customerId = Auth::guard('customer')->id();
        $sessionId = $this->getSessionId();

        $count = Cart::where(function($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->sum('quantity');

        return response()->json(['count' => $count]);
    }

    /**
     * Display cart page
     */
    public function viewCart()
    {
        $customerId = Auth::guard('customer')->id();
        $sessionId = $this->getSessionId();

        $cartItems = Cart::with('product.category')
            ->where(function($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        $totalAmount = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('cart.view', compact('cartItems', 'totalAmount'));
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        $product = $cart->product;

        if ($product->product_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock!'
            ], 400);
        }

        $cart->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated!',
            'total' => $cart->quantity * $cart->price
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!'
        ]);
    }

    /**
     * Get or create session ID for guest users
     */
    private function getSessionId()
    {
        if (!session()->has('cart_session')) {
            session(['cart_session' => Str::random(40)]);
        }
        return session('cart_session');
    }

    /**
     * Merge guest cart when user logs in
     */
    public function mergeGuestCart($customerId)
    {
        $sessionId = $this->getSessionId();

        Cart::where('session_id', $sessionId)
            ->update(['customer_id' => $customerId, 'session_id' => null]);
    }
}
