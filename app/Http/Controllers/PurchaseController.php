<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Events\ProductPurchased;


class PurchaseController extends Controller
{

    public function purchase(Request $request)
    {
        if (empty($request->product_id)){
            return response()->json(['message' => 'product_id is empty .'],400);
        }

        $product = Product::where('status', 'available')->where('amount', '>', 0)->find($request->product_id);

        if (empty($product)){
            return response()->json(['message' => 'Product not available.'],400);
        }

        $purchase = new Purchase();
        $purchase->user_id = $request->user_id;
        $purchase->product_id = $product->id;
        $purchase->generateCode();
        $purchase->save();

        event(new ProductPurchased($product, 1));

        return response()->json(['message' => 'Purchase created successfully.', 'code' => $purchase->code]);
    }
}
