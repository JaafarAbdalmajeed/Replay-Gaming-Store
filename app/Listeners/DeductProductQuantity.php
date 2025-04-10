<?php

namespace App\Listeners;

use Throwable;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeductProductQuantity
{
    protected $cart;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreate $event)
    {
        try{
        $order= $event->order;
        foreach ($order->products as $product) {
            $product->decrement('quantity',$product->order_item->quantity);
            // Product::where('id', $item->product_id)
            //     ->decrement('quantity', $item->quantity);
        }
        } catch ( Throwable $e ) {

        }
    }
}
