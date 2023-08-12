<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{

    public function purchase(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $purchase = new Purchase();
        $purchase->user_id = $request->user_id;
        $purchase->product_id = $product->id;
        $purchase->generateCode();
        $purchase->save();
        return response()->json(['message' => 'Purchase created successfully.', 'code' => $purchase->code]);
    }
    // Остальные методы для проверки статуса и т.д.
}
