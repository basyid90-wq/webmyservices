<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ShopAuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Shop/Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $email = $request->input('email');
            if (str_contains($email, 'admin')) {
                return redirect()->route('shop.admin.dashboard');
            }
            return redirect()->route('shop.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showRegister()
    {
        return Inertia::render('Shop/Auth/Register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('shop.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::location('/shop');
    }

    public function dashboard()
    {
        $query = \App\Models\Shop\Order::with(['items.product', 'shipment.provider'])->latest();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        $orders = $query->take(10)->get();

        return Inertia::render('Shop/Dashboard', ['orders' => $orders]);
    }

    public function orderDetail(\App\Models\Shop\Order $order)
    {
        if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'shipment.provider']);

        return Inertia::render('Shop/OrderDetail', ['order' => $order]);
    }

    // Admin dashboard pages
    public function adminDashboard() { return Inertia::render('Shop/Admin/Dashboard'); }
    public function adminOrders() { return Inertia::render('Shop/Admin/Orders'); }
    public function adminProducts() { return Inertia::render('Shop/Admin/Products'); }
    public function adminShipping() { return Inertia::render('Shop/Admin/Shipping'); }
    public function adminPayments() { return Inertia::render('Shop/Admin/Payments'); }
    public function adminCoupons() { return Inertia::render('Shop/Admin/Coupons'); }
    public function adminCustomers() { return Inertia::render('Shop/Admin/Customers'); }

    // User dashboard pages
    public function userDashboard() { return Inertia::render('Shop/User/Dashboard'); }
    public function userOrders() { return Inertia::render('Shop/User/Orders'); }
    public function userTracking() { return Inertia::render('Shop/User/Tracking'); }
}
