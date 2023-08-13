<?php

namespace App\Listeners;

use App\Events\ProductPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Product;

class UpdateProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(ProductPurchased $event)
    {
        $product = $event->product;
        $newAmount = $product->amount - $event->amount;
        $product->update(['amount' => $newAmount]);
    }
}
