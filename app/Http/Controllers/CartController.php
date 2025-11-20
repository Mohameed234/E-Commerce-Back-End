<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Add product to cart
    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if product exists
        $product = Product::find($data['product_id']);
        if (!$product) {
            return response()->json(['message' => "Product with ID {$data['product_id']} does not exist"], 404);
        }

        // Add or update cart
        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $data['product_id']],
            ['quantity' => $data['quantity']]
        );

        return response()->json([
            'message' => 'Product added to cart successfully',
            'cart' => $cart
        ]);
    }

    // Update quantity in cart
    public function updateCart(Request $request, $product_id)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())->where('product_id', $product_id)->first();

        if (!$cart) {
            return response()->json(['message' => "Product with ID {$product_id} is not in your cart"], 404);
        }

        $cart->update(['quantity' => $data['quantity']]);

        return response()->json([
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ]);
    }

    // Remove product from cart
    public function removeFromCart($product_id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('product_id', $product_id)->first();

        if (!$cart) {
            return response()->json(['message' => "Product with ID {$product_id} is not in your cart"], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Product removed from cart']);
    }

    // View all products in cart
    public function viewCart()
    {
        $cart = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty']);
        }

        return response()->json($cart);
    }
}
