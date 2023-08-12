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

        $expiryDate = now()->addHours($request->rental_hours);
        $expiryDateFormat = $expiryDate->format('Y-m-d H:i:s');

        $rental = new Rental();
        $rental->user_id = $request->user_id;
        $rental->product_id = $product->id;
        $rental->expiry_date = $expiryDateFormat;
        $rental->save();

        return response()->json(['message' => 'Rental created successfully.', 'expiry_date' => $expiryDateFormat]);
    }

    public function extend(Request $request, Rental $rental)
    {

        if ($rental->isExpired()) {
            return response()->json(['error' => 'Cannot extend expired rental.'], 400);
        }

        if (empty($request->extend_hours)) {
            return response()->json(['error' => "Variable 'extend_hours' is empty !"], 400);
        }
        $hours = $request->extend_hours;
        $rental->extendRental($hours);
        $expiryDateFormat = $rental->expiry_date->format('Y-m-d H:i:s');

        return response()->json(['message' => 'Rental extended successfully.', 'new_expiry_date' => $expiryDateFormat]);
    }

    // Остальные методы для проверки статуса и т.д.
}
