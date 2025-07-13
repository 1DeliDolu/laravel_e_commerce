<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Process checkout and create order
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500'
        ]);

        $customerId = Auth::guard('customer')->id();
        $sessionId = $this->getSessionId();

        // Get cart items with eager loading for better performance
        $cartItems = Cart::with(['product' => function($query) {
            $query->select('id', 'product_title', 'product_price', 'product_quantity');
        }])
            ->where(function($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty!'
            ], 400);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $tax = 0; // No tax for now
        $shipping = 0; // Free shipping
        $total = $subtotal + $tax + $shipping;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customerId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'status' => 'pending',
                'order_date' => Carbon::now()
            ]);

            // Prepare batch updates for better performance
            $orderItems = [];
            $productUpdates = [];

            foreach ($cartItems as $cartItem) {
                // Check stock availability
                if ($cartItem->product->product_quantity < $cartItem->quantity) {
                    throw new \Exception("Insufficient stock for product: " . $cartItem->product->product_title);
                }

                // Prepare order item data
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_title' => $cartItem->product->product_title,
                    'product_price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'total' => $cartItem->quantity * $cartItem->price,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Prepare product quantity updates
                $productUpdates[$cartItem->product_id] = $cartItem->quantity;
            }

            // Batch insert order items for better performance
            OrderItem::insert($orderItems);

            // Batch update product quantities
            foreach ($productUpdates as $productId => $quantityToDeduct) {
                Product::where('id', $productId)->decrement('product_quantity', $quantityToDeduct);
            }

            // Clear cart
            $cartItems->each(function($item) {
                $item->delete();
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }    /**
     * Generate and download PDF receipt
     */
    public function downloadReceipt($orderId)
    {
        $order = Order::with(['orderItems' => function($query) {
            $query->select('id', 'order_id', 'product_title', 'product_price', 'quantity', 'total');
        }])->findOrFail($orderId);

        // Simple PDF generation for faster performance
        $pdf = Pdf::loadView('checkout.receipt', compact('order'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        $filename = 'receipt-' . $order->order_number . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Get checkout form data
     */
    public function getCheckoutData()
    {
        $customerId = Auth::guard('customer')->id();
        $sessionId = $this->getSessionId();

        // Get cart items
        $cartItems = Cart::with('product.category')
            ->where(function($query) use ($customerId, $sessionId) {
                if ($customerId) {
                    $query->where('customer_id', $customerId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        $customerData = [];
        if ($customerId) {
            $customer = Auth::guard('customer')->user();
            $customerData = [
                'name' => $customer->full_name, // Use the accessor
                'email' => $customer->email,
                'phone' => $customer->phone ?? '',
                'address' => $customer->address ?? ''
            ];
        }

        return response()->json([
            'cart_items' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => 0,
            'shipping' => 0,
            'total' => $subtotal,
            'customer_data' => $customerData
        ]);
    }

    /**
     * Get session ID for guest users
     */
    private function getSessionId()
    {
        if (!session()->has('cart_session')) {
            session(['cart_session' => \Illuminate\Support\Str::random(40)]);
        }
        return session('cart_session');
    }
}
