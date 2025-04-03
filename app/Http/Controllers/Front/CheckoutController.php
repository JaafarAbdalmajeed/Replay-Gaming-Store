<?php

namespace App\Http\Controllers\Front;

use Throwable;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\Cart\CartRepository;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->isEmpty()) {
            return Redirect::route('home');
        }

        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames()
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        // Database Transaction
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                // Create an order for each store
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod'
                ]);

                // Add items to the order
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity
                    ]);
                }

                // Attach addresses to the order
                foreach ($request->post('addr') as $type => $address) {
                    $order->addresses()->create(array_merge($address, ['type' => $type]));
                }
            }

            $cart->empty();

            DB::commit();
            return response()->json(['message' => 'Order placed successfully!'], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while placing the order.'], 500);
        }
    }
}
