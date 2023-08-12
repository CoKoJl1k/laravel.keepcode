<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function rent(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if (!$product->is_rentable) {
            return response()->json(['error' => 'This product is not available for rental.'], 400);
        }

    //    $user = auth()->user();
        $expiryDate = now()->addHours($request->rental_hours);

        $rental = new Rental();
        $rental->user_id = $request->user_id;
        $rental->product_id = $product->id;
        $rental->expiry_date = $expiryDate;
        $rental->save();

        return response()->json(['message' => 'Rental created successfully.', 'expiry_date' => $expiryDate]);
    }

    public function extend(Request $request, Rental $rental)
    {
        if ($rental->isExpired()) {
            return response()->json(['error' => 'Cannot extend expired rental.'], 400);
        }

        $hours = $request->extend_hours;
        $rental->extendRental($hours);

        return response()->json(['message' => 'Rental extended successfully.', 'new_expiry_date' => $rental->expiry_date]);
    }

    // Остальные методы для проверки статуса и т.д.
}
