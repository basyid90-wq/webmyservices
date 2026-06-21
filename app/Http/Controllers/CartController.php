<?php

namespace App\Http\Controllers;

use App\Models\Shop\Cart;
use App\Models\Shop\CartItem;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:shop_products,id',
            'quantity' => 'integer|min:1',
        ]);

        $cart = $this->getCart();
        $item = $cart->items()->where('shop_product_id', $request->product_id)->first();

        if ($item) {
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            $cart->items()->create([
                'shop_product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $item->update(['quantity' => $request->quantity]);

        return back();
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back();
    }

    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }
}
