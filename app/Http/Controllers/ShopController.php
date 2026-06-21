<?php

namespace App\Http\Controllers;

use App\Models\Shop\Cart;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function catalog(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('sort_order')->latest()->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Shop/Catalog', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search']),
        ]);
    }

    public function product(Product $product)
    {
        $product->load('category');
        $related = Product::where('is_active', true)
            ->where('shop_category_id', $product->shop_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return Inertia::render('Shop/Product', [
            'product' => $product,
            'related' => $related,
        ]);
    }

    public function cart()
    {
        $cart = $this->getCart();
        $cart->load('items.product');

        return Inertia::render('Shop/Cart', [
            'cart' => $cart,
        ]);
    }

    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }
}
