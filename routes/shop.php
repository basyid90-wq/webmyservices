<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopAuthController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'catalog'])->name('catalog');
Route::get('/product/{product:slug}', [ShopController::class, 'product'])->name('product');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/orders/{order:order_number}/success', [CheckoutController::class, 'success'])->name('order.success');

Route::get('/login', [ShopAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [ShopAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [ShopAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [ShopAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [ShopAuthController::class, 'logout'])->name('logout');

// User dashboard
Route::get('/dashboard', [ShopAuthController::class, 'userDashboard'])->name('dashboard');
Route::get('/orders/{order}', [ShopAuthController::class, 'orderDetail'])->name('order.detail');
Route::get('/user/orders', [ShopAuthController::class, 'userOrders'])->name('user.orders');
Route::get('/user/tracking', [ShopAuthController::class, 'userTracking'])->name('user.tracking');

// Admin dashboard
Route::get('/admin', [ShopAuthController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/orders', [ShopAuthController::class, 'adminOrders'])->name('admin.orders');
Route::get('/admin/products', [ShopAuthController::class, 'adminProducts'])->name('admin.products');
Route::get('/admin/shipping', [ShopAuthController::class, 'adminShipping'])->name('admin.shipping');
Route::get('/admin/payments', [ShopAuthController::class, 'adminPayments'])->name('admin.payments');
Route::get('/admin/coupons', [ShopAuthController::class, 'adminCoupons'])->name('admin.coupons');
Route::get('/admin/customers', [ShopAuthController::class, 'adminCustomers'])->name('admin.customers');