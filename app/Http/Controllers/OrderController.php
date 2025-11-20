<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $userId = auth()->id(); // assuming user is authenticated

        // get all items from the cart of the user
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $orderItems = [];

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                if (!$product) {
                    return response()->json([
                        'message' => "Product with ID {$cartItem->product_id} does not exist"
                    ], 404);
                }

                // check the product quantity
                try {
                    $product->checkStock();
                } catch (\Exception $e) {
                    return response()->json(['message' => $e->getMessage()], 400);
                }

                // check if product has enough stock
                if ($product->quantity < $cartItem->quantity) {
                    return response()->json([
                        'message' => "Product {$product->name} does not have enough stock"
                    ], 400);
                }

                // decrement the product quantity
                $product->decrement('quantity', $cartItem->quantity);

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ];

                $total += $product->price * $cartItem->quantity;
            }

            // إنشاء الأوردر
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'address' => $data['address'],
                'phone' => $data['phone'],
                'total' => $total,
            ]);

            // حفظ تفاصيل المنتجات في order_items
            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            // مسح الكارت بعد النجاح
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json([
                'order_number' => $order->order_number,
                'total' => $total,
                'items' => $orderItems
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('OrderController store error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Order failed', 'error' => $e->getMessage()], 500);
        }
    }
}
