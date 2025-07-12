<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Show customer registration form
     */
    public function register()
    {
        return view('customers.register');
    }

    /**
     * Handle customer registration
     */
    public function postRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $customer = Customer::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('customer.login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Show customer login form
     */
    public function login()
    {
        return view('customers.login');
    }

    /**
     * Handle customer login
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    /**
     * Customer dashboard
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        return view('customers.dashboard', compact('customer'));
    }

    /**
     * Customer logout
     */
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'Logged out successfully');
    }

    /**
     * Show edit customer profile form
     */
    public function edit()
    {
        $customer = Auth::guard('customer')->user();
        return view('customers.update_customer', compact('customer'));
    }

    /**
     * Update customer profile
     */
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $updateData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $customer->update($updateData);

            return redirect()->route('customer.dashboard')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Profile update failed: ' . $e->getMessage());
        }
    }
}
